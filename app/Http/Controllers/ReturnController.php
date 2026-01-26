<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\students;
use App\Models\teachers;
use App\Models\std_borrow;
use App\Models\t_borrow;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReturnController extends Controller
{
    public function index()
    {
        // Get all borrowed books (status = 'borrowed')
        $borrowedBooks = book::where('status', 'borrowed')->orderBy('title')->get();
        return view('staff.return', compact('borrowedBooks'));
    }

    // API endpoint to get borrower info
    public function getBorrowerInfo(Request $request)
    {
        $id = $request->query('id');

        // Try to find as student by no_matrik
        $student = students::where('no_matrik', $id)->first();
        if ($student) {
            return response()->json([
                'type' => 'student',
                'id' => $student->id,
                'no_matrik' => $student->no_matrik,
                'name' => $student->name,
                'program' => $student->course,
                'phone' => $student->phone,
            ]);
        }

        // Try to find as teacher by no_matrik
        $teacher = teachers::where('no_matrik', $id)->first();
        if ($teacher) {
            return response()->json([
                'type' => 'teacher',
                'id' => $teacher->id,
                'no_matrik' => $teacher->no_matrik,
                'name' => $teacher->name,
                'program' => $teacher->department,
                'phone' => $teacher->phone,
            ]);
        }

        return response()->json(['error' => 'Peminjam tidak dijumpai'], 404);
    }

    // API endpoint to get book info
    public function getBookInfo(Request $request)
    {
        $id = $request->query('id');

        $book = book::where('barcode', $id)->orWhere('id', $id)->first();
        if (!$book) {
            return response()->json(['error' => 'Buku tidak dijumpai'], 404);
        }

        return response()->json([
            'id' => $book->id,
            'barcode' => $book->barcode,
            'title' => $book->title,
            'author' => $book->author,
            'year' => $book->year,
            'status' => $book->status,
        ]);
    }

    // Mark borrow as returned
    public function update(Request $request)
    {
        $request->validate([
            'borrower_type' => 'required|in:student,teacher',
            'borrower_no_matrik' => 'required|string',
            'book_id' => 'required',
        ]);

        $returnedDate = Carbon::today();
        // Prefer `barcode` for matching borrow records. If only `book_id` (numeric) is provided,
        // resolve it to the book's barcode so we can match the `std_borrows`/`t_borrows` rows.
        $bookIdentifier = null;
        if ($request->filled('barcode')) {
            $bookIdentifier = $request->barcode;
        } elseif ($request->filled('book_id') && is_numeric($request->book_id)) {
            $foundBook = book::find($request->book_id);
            if ($foundBook) {
                $bookIdentifier = $foundBook->barcode;
            }
        } else {
            $bookIdentifier = $request->book_id ?? null;
        }

        if ($request->borrower_type === 'student') {
            // std_borrows table uses `no_matrik` and `barcode` columns
            $borrow = std_borrow::where('no_matrik', $request->borrower_no_matrik)
                ->when($bookIdentifier, function($q) use ($bookIdentifier) {
                    $q->where('barcode', $bookIdentifier);
                })
                ->whereNull('returned_date')
                ->first();

            if ($borrow) {
                $borrow->update([
                    'returned_date' => $returnedDate,
                    'borrow_status' => 'returned',
                ]);
            }
        } else {
            // t_borrows table also uses `no_matrik` and `barcode`
            $borrow = t_borrow::where('no_matrik', $request->borrower_no_matrik)
                ->when($bookIdentifier, function($q) use ($bookIdentifier) {
                    $q->where('barcode', $bookIdentifier);
                })
                ->whereNull('returned_date')
                ->first();

            if ($borrow) {
                $borrow->update([
                    'returned_date' => $returnedDate,
                    'borrow_status' => 'returned',
                ]);
            }
        }

        // Find the book by id or barcode and update its status
        $book = null;
        if (is_numeric($request->book_id)) {
            $book = book::find($request->book_id);
        }
        if (!$book && ($request->book_id || $request->barcode)) {
            $identifier = $request->book_id ?? $request->barcode;
            $book = book::where('barcode', $identifier)->orWhere('id', $identifier)->first();
        }

        if ($book) {
            $book->update(['status' => 'available']);
        }

        return response()->json(['success' => 'Pemulangan buku berjaya dicatat']);
    }
}

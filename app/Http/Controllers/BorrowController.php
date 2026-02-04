<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\students;
use App\Models\teachers;
use App\Models\std_borrow;
use App\Models\t_borrow;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function index()
    {
        // Get all available books
        $books = book::where('status', '!=', 'borrowed')->orderBy('title')->get();

        // Build active borrow records (students + teachers) to show on staff page
        $records = collect();

        $stds = std_borrow::where('borrow_status', 'active')->get();
        foreach ($stds as $s) {
            $borrowerName = students::where('no_matrik', $s->no_matrik)->value('name') ?: $s->no_matrik;
            $bookTitle = book::where('barcode', $s->barcode)->value('title') ?: $s->barcode;

            $records->push([
                'type' => 'Student',
                'borrower' => $borrowerName,
                'book' => $bookTitle,
                'borrowed_date' => $s->borrowed_date ? Carbon::parse($s->borrowed_date)->toDateString() : '',
            ]);
        }

        $ts = t_borrow::where('borrow_status', 'active')->get();
        foreach ($ts as $t) {
            $borrowerName = teachers::where('no_matrik', $t->no_matrik)->value('name') ?: $t->no_matrik;
            $bookTitle = book::where('barcode', $t->barcode)->value('title') ?: $t->barcode;

            $records->push([
                'type' => 'Teacher',
                'borrower' => $borrowerName,
                'book' => $bookTitle,
                'borrowed_date' => $t->borrowed_date ? Carbon::parse($t->borrowed_date)->toDateString() : '',
            ]);
        }

        return view('staff.borrow', compact('books', 'records'));
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

    // Store borrow record
    public function store(Request $request)
    {
        $request->validate([
            'borrower_type' => 'required|in:student,teacher',
            'no_matrik' => 'required|string',
            'barcode' => 'required|integer',
        ]);

        $bookId = $request->borrower_type === 'student' 
            ? null 
            : null;

        $borrowedDate = Carbon::today();
        $dueDate = Carbon::today()->addDays(7); // 7 days borrow period

        $check = book::where('barcode', $request->barcode)
            ->where('status', 'borrowed')
            ->first();

        if ($check) {
            return response()->json(['error' => 'Buku masih dipinjam']);
        }

        else if ($request->borrower_type === 'student') {
        std_borrow::create([
            'no_matrik'     => $request->no_matrik,
            'barcode'       => $request->barcode, 
            'borrowed_date' => $borrowedDate,
            'due_date'      => $dueDate,
            'borrow_status' => 'active',
        ]);
        } else {
            t_borrow::create([
                'no_matrik'     => $request->no_matrik,
                'barcode'       => $request->barcode, 
                'borrowed_date' => $borrowedDate,
                'due_date'      => $dueDate,
                'borrow_status' => 'active',
            ]);
        }

        // Update book status to borrowed
        book::find($request->book_id)->update(['status' => 'borrowed']);

        return response()->json(['success' => 'Peminjaman buku berjaya dicatat']);
    }
}

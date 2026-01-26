<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\book;

class BookController extends Controller
{
    // Tunjuk senarai buku (paginate 10), disort mengikut status: hilang/rosak > dipinjam > tersedia
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        
        $books = book::orderByRaw("CASE 
                WHEN LOWER(status) IN ('hilang', 'rosak') THEN 1
                WHEN LOWER(status) = 'dipinjam' THEN 2
                ELSE 3
            END")
            ->orderBy('title');
        
        if (!empty($search)) {
            $books = $books->where('title', 'like', '%' . $search . '%')
                          ->orWhere('barcode', 'like', '%' . $search . '%')
                          ->orWhere('author', 'like', '%' . $search . '%');
        }
        
        $books = $books->paginate(10)->withQueryString();
        return view('admin.book', compact('books', 'search'));
    }

    // Return only table rows for AJAX requests
    public function rows(Request $request)
    {
        $search = $request->query('search', '');

        $booksQuery = book::orderByRaw("CASE 
                WHEN LOWER(status) IN ('hilang', 'rosak') THEN 1
                WHEN LOWER(status) = 'dipinjam' THEN 2
                ELSE 3
            END")
            ->orderBy('title');

        if (!empty($search)) {
            $booksQuery = $booksQuery->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('barcode', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%');
            });
        }

        $books = $booksQuery->paginate(10)->withQueryString();
        return view('admin._book_rows', compact('books'));
    }

    // Form tambah buku
    public function create()
    {
        return view('admin.addbook');
    }

    // Simpan buku baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'barcode' => 'required|string|unique:books,barcode',
            'title'   => 'required|string|max:255',
            'author'  => 'nullable|string|max:255',
            'year'    => 'nullable|integer',
        ]);

        // Ensure newly added books default to available regardless of input
        $data['status'] = 'available';

        book::create($data);

        return redirect()->route('book.index')->with('success', 'Buku ditambah.');
    }

    // Import books from CSV file
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('import_file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        if (!$handle) {
            return redirect()->back()->with('error', 'Gagal membuka fail import');
        }
        $header = null;
        $created = 0;
        $skipped = 0;
        $importErrors = [];
        $rowNumber = 0;

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $rowNumber++;

            // skip empty rows
            if (count($row) === 1 && trim($row[0]) === '') {
                continue;
            }

            if (!$header) {
                $header = $row;
                continue;
            }

            // map columns by position: barcode,title,author,year,status
            $barcode = isset($row[0]) ? trim($row[0]) : null;
            $title = isset($row[1]) ? trim($row[1]) : null;
            $author = isset($row[2]) ? trim($row[2]) : null;
            $year = isset($row[3]) ? trim($row[3]) : null;
            $status = isset($row[4]) ? trim($row[4]) : 'available';

            if (empty($barcode) || empty($title)) {
                $skipped++;
                $importErrors[] = "Baris {$rowNumber}: Missing barcode or title";
                continue;
            }

            // skip if exists
            if (book::where('barcode', $barcode)->exists()) {
                $skipped++;
                $importErrors[] = "Baris {$rowNumber}: Barcode {$barcode} sudah wujud";
                continue;
            }

            try {
                book::create([
                    'barcode' => $barcode,
                    'title' => $title,
                    'author' => $author,
                    'year' => is_numeric($year) ? (int)$year : null,
                    'status' => $status ?: 'available',
                ]);
                $created++;
            } catch (\Exception $e) {
                $skipped++;
                $importErrors[] = "Baris {$rowNumber}: Gagal menyimpan ({$e->getMessage()})";
            }
        }

        fclose($handle);

        $flash = ['success' => "Import selesai: {$created} ditambah, {$skipped} diabaikan"];
        if (!empty($importErrors)) {
            $flash['import_errors'] = $importErrors;
        }

        return redirect()->back()->with($flash);
    }

    // Form edit buku
    public function edit(book $book)
    {
        return view('admin.editbook', compact('book'));
    }

    // Kemaskini buku
    public function update(Request $request, book $book)
    {
        $data = $request->validate([
            'barcode' => 'required|string|unique:books,barcode,' . $book->id,
            'title'   => 'required|string|max:255',
            'author'  => 'nullable|string|max:255',
            'year'    => 'nullable|integer',
            'status'  => 'required|string|max:50',
        ]);

        $book->update($data);

        return redirect()->route('book.index')->with('success', 'Buku dikemaskini.');
    }

    // Padam buku
    public function destroy(book $book)
    {
        $book->delete();
        return redirect()->route('book.index')->with('success', 'Buku dipadam.');
    }
}

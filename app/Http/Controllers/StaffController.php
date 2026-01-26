<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function main()
    {
        // Ambil semua buku, sort mengikut status: hilang/rosak > dipinjam > tersedia
        $books = book::orderByRaw("CASE 
                WHEN LOWER(status) IN ('hilang', 'rosak') THEN 1
                WHEN LOWER(status) = 'dipinjam' THEN 2
                ELSE 3
            END")
            ->orderBy('title')
            ->paginate(10);
        
        return view('staff.main', compact('books'));
    }

    // Return only table rows for AJAX requests on staff main page
    public function rows(Request $request)
    {
        $search = $request->query('search', '');

        $query = book::orderByRaw("CASE 
                WHEN LOWER(status) IN ('hilang', 'rosak') THEN 1
                WHEN LOWER(status) = 'dipinjam' THEN 2
                ELSE 3
            END")->orderBy('title');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $books = $query->paginate(10)->withQueryString();
        return view('staff._main_book_rows', compact('books'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\students;
use App\Models\teachers;
use App\Models\book;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = students::count();
        $totalTeachers = teachers::count();
        $totalBooks = book::count();
        // Hitung buku yang dipinjam berdasarkan status
        $totalBorrow = book::whereRaw('LOWER(status) = ?', ['borrowed'])->count();
        // Hitung buku yang hilang atau rosak
        $notReturned = book::whereRaw('LOWER(status) IN (?, ?)', ['lost', 'damaged'])->count();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalBooks',
            'totalBorrow',
            'notReturned'
        ));
    }
}

<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ReturnController;

// Web Routes
Route::get('/', function () {
    return view('index');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('index');
})->name('index');

Route::get('/layouts', function () {
    return view('layouts.app');
})->name('layouts');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// POST handler for login form
Route::post('/login', [LoginController::class, 'login']);

// Logout (optional)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Admin Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/record', [RecordController::class, 'index'])->name('record');

Route::get('/student', [StudentController::class, 'index'])->name('student');
Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
Route::post('/student', [StudentController::class, 'store'])->name('student.store');
Route::post('/student/import', [StudentController::class, 'import'])->name('student.import');
Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
Route::put('/student/{id}', [StudentController::class, 'update'])->name('student.update');
Route::get('/student/rows', [StudentController::class, 'rows'])->name('student.rows');

// Teacher list
Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher');
Route::get('/teacher/create', [TeacherController::class, 'create'])->name('teacher.create');
Route::post('/teacher', [TeacherController::class, 'store'])->name('teacher.store');
Route::post('/teacher/import', [TeacherController::class, 'import'])->name('teacher.import');
Route::get('/teacher/{id}/edit', [TeacherController::class, 'edit'])->name('teacher.edit');
Route::put('/teacher/{id}', [TeacherController::class, 'update'])->name('teacher.update');
Route::get('/teacher/rows', [TeacherController::class, 'rows'])->name('teacher.rows');

// Book resource routes (index, create, store, edit, update, destroy)
Route::resource('book', BookController::class)->except(['show']);
Route::get('/book/rows', [BookController::class, 'rows'])->name('book.rows');
Route::post('/book/import', [BookController::class, 'import'])->name('book.import');

Route::get('/addbook', function () {
    return view('admin.addbook');
})->name('addbook');

Route::get('/addperson', function () {
    return view('admin.addperson');
})->name('addperson');

Route::get('/addstudent', function () {
    return view('admin.addstudent');
})->name('addstudent');

Route::get('/addteacher', function () {
    return view('admin.addteacher');
})->name('addteacher');
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

//Staff Routes
Route::get('/main', [StaffController::class, 'main'])->name('main');
Route::get('/main/rows', [StaffController::class, 'rows'])->name('main.rows');

Route::get('/borrow', [BorrowController::class, 'index'])->name('borrow');
Route::post('/borrow', [BorrowController::class, 'store'])->name('borrow.store');
Route::get('/api/borrower-info', [BorrowController::class, 'getBorrowerInfo']);
Route::get('/api/book-info', [BorrowController::class, 'getBookInfo']);

Route::get('/return', [ReturnController::class, 'index'])->name('return');
Route::put('/return', [ReturnController::class, 'update'])->name('return.update');
Route::get('/api/borrower-info-return', [ReturnController::class, 'getBorrowerInfo']);
Route::get('/api/book-info-return', [ReturnController::class, 'getBookInfo']);
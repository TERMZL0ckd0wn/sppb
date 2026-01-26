<?php

namespace App\Http\Controllers;

use App\Models\std_borrow;
use App\Models\t_borrow;
use App\Models\students;
use App\Models\teachers;
use App\Models\book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $records = collect();

        $stds = std_borrow::get();
        foreach ($stds as $s) {
            $borrowed = $s->borrowed_date;
            $due = $s->due_date;
            $returned = $s->returned_date;

            $rowClass = '';
            // Default: white (no extra class)
            if (empty($returned)) {
                if ($due) {
                    $dueDt = Carbon::parse($due)->startOfDay();
                    if ($today->greaterThanOrEqualTo($dueDt)) {
                        $rowClass = 'bg-red-100';
                    } elseif ($today->diffInDays($dueDt) <= 3) {
                        $rowClass = 'bg-yellow-100';
                    }
                }
            }

            // Resolve borrower name and book title
            $borrowerName = students::where('no_matrik', $s->no_matrik)->value('name') ?: $s->no_matrik;
            $bookTitle = book::where('barcode', $s->barcode)->value('title') ?: $s->barcode;

            // Determine status: if overdue and not returned, status is "late"
            $status = $s->borrow_status ?: '-';
            if (empty($returned) && $due) {
                $dueDt = Carbon::parse($due)->startOfDay();
                if ($today->greaterThan($dueDt)) {
                    $status = 'late';
                    // Update database record to reflect the late status
                    $s->update(['borrow_status' => 'late']);
                }
            }

            $records->push([
                'type' => 'Student',
                'borrower' => $borrowerName,
                'book' => $bookTitle,
                'borrowed_date' => $borrowed ? Carbon::parse($borrowed)->toDateString() : '',
                'due_date' => $due ? Carbon::parse($due)->toDateString() : '',
                'returned_date' => $returned ? Carbon::parse($returned)->toDateString() : null,
                'status' => $status,
                'row_class' => $rowClass,
            ]);
        }

        $ts = t_borrow::get();
        foreach ($ts as $t) {
            $borrowed = $t->borrowed_date;
            $due = $t->due_date;
            $returned = $t->returned_date;

            $rowClass = '';
            if (empty($returned)) {
                if ($due) {
                    $dueDt = Carbon::parse($due)->startOfDay();
                    if ($today->greaterThanOrEqualTo($dueDt)) {
                        $rowClass = 'bg-red-600';
                    } elseif ($today->diffInDays($dueDt) <= 3) {
                        $rowClass = 'bg-yellow-100';
                    }
                }
            }

            // Resolve borrower name and book title
            $borrowerName = teachers::where('no_matrik', $t->no_matrik)->value('name') ?: $t->no_matrik;
            $bookTitle = book::where('barcode', $t->barcode)->value('title') ?: $t->barcode;

            // Determine status: if overdue and not returned, status is "late"
            $status = ($t->borrow_status ?? $t->status_pinjaman) ?: '-';
            if (empty($returned) && $due) {
                $dueDt = Carbon::parse($due)->startOfDay();
                if ($today->greaterThan($dueDt)) {
                    $status = 'late';
                    // Update database record to reflect the late status
                    $t->update(['borrow_status' => 'late']);
                }
            }

            $records->push([
                'type' => 'Teacher',
                'borrower' => $borrowerName,
                'book' => $bookTitle,
                'borrowed_date' => $borrowed ? Carbon::parse($borrowed)->toDateString() : '',
                'due_date' => $due ? Carbon::parse($due)->toDateString() : '',
                'returned_date' => $returned ? Carbon::parse($returned)->toDateString() : null,
                'status' => $status,
                'row_class' => $rowClass,
            ]);
        }

        // Sort primarily by borrow_status in custom order: late -> active -> returned
        // then by borrowed_date descending within each status group.
        $order = [
            'late' => 0,
            'active' => 1,
            'returned' => 2,
        ];

        $items = $records->all();
        usort($items, function ($a, $b) use ($order) {
            $sa = strtolower($a['status'] ?? '');
            $sb = strtolower($b['status'] ?? '');
            $pa = $order[$sa] ?? 99;
            $pb = $order[$sb] ?? 99;

            if ($pa !== $pb) {
                return $pa <=> $pb;
            }

            // Same status: sort by borrowed_date descending (newest first)
            $da = $a['borrowed_date'] ?? '';
            $db = $b['borrowed_date'] ?? '';
            return strcmp($db, $da);
        });

        $records = collect($items)->values();

        return view('admin.record', compact('records'));
    }
}

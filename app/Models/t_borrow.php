<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class t_borrow extends Model
{
    protected $table = 't_borrows';
    
    protected $fillable = [
        'no_matrik',
        'barcode',
        'borrowed_date',
        'due_date',
        'returned_date',
        'borrow_status',
    ];

    public function teacher()
    {
        return $this->belongsTo(teachers::class, 'no_matrik');
    }

    public function book()
    {
        return $this->belongsTo(book::class, 'barcode');
    }
}

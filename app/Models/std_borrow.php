<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class std_borrow extends Model
{
    protected $table = 'std_borrows';
    
    protected $fillable = [
        'no_matrik',
        'barcode',
        'borrowed_date',
        'due_date',
        'returned_date',
        'borrow_status',
    ];

    public function student()
    {
        return $this->belongsTo(students::class, 'no_matrik');
    }

    public function book()
    {
        return $this->belongsTo(book::class, 'barcode');
    }
}

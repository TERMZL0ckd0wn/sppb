<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    protected $table = 'books';
    
    protected $fillable = [
        'barcode',
        'title',
        'author',
        'year',
        'status',
    ];

    public function tborrows()
    {
        return $this->hasMany(TBorrow::class, 'barcode');
    }

    public function stdborrows()
    {
        return $this->hasOne(StdBorrow::class, 'barcode');

    }
}
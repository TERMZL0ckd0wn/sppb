<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class teachers extends Model
{
    protected $table = 'teachers';
    
    protected $fillable = [
        'no_matrik',
        'name',
        'email',
        'phone',
        'department',
    ];

    public function tborrows()
    {
        return $this->hasMany(t_borrow::class, 'no_matrik');
    }
}

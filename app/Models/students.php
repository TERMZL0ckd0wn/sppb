<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    protected $table = 'students';
    
    protected $fillable = [
        'no_matrik',
        'name',
        'email',
        'phone',
        'course',
        'kohort',
    ];

    public function stdborrows()
    {
        return $this->hasMany(std_borrow::class, 'no_matrik');
    }
}

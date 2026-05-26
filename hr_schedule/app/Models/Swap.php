<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Swap extends Model
{
    protected $fillable = [
        'shift_id',
        'original_employee',
        'swapped_with',
        'day',
        'time',
        'status'
    ];
}

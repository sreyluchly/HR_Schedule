<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
  protected $fillable = [
        'employee_id',
        'posted_by',
        'shift_date',
        'original_shift',
        'new_shift',
        'claimed_by',
        'status',
    ];
}

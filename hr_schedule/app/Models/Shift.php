<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
  protected $fillable = [
        'employee_id',
        'posted_by',
        'shift_date',
        'original_shift', // <--- បន្ថែមត្រង់នេះ
        'new_shift',      // <--- បន្ថែមត្រង់នេះ
        'claimed_by',
        'status',
    ];
}

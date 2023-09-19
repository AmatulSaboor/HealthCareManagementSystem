<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorWorkingDay extends Model
{
    use HasFactory, SoftDeletes;
    protected $appends = ['day_name'];
    public static $WORKING_DAYS = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday'
    ];
    protected $fillable = ['user_id', 'day'];

    public function getDayNameAttribute()
    {
        return self::$WORKING_DAYS[$this->day];
    }
}
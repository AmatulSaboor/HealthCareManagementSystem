<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id', 'doctor_id', 'appointment_date', 'appointment_time', 'is_scheduled', 'is_cancelled', 'is_rescheduled', 'is_done'];
}
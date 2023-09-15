<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['patient_id', 'doctor_id', 'appointment_date', 'appointment_time', 'is_scheduled', 'is_cancelled', 'is_rescheduled', 'is_done'];
    public function patientUser()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }
    public function doctorUser()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }
}
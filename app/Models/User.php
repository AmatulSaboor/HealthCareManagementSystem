<?php

namespace App\Models;

use App\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function doctorDetail()
    {
        return $this->hasOne(DoctorDetail::class);
    }
    public function patientDetail()
    {
        return $this->hasOne(PatientDetail::class);
    }
    public function doctorWorkingDays()
    {
        return $this->hasMany(DoctorWorkingDay::class);
    }
    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'id', 'patient_id');
    }
    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'id', 'doctor_id');
    }
    public function getFirstNameAttribute()
    {
        return explode(' ', $this->attributes['name'])[0] ?? '';
    }
    public function getLastNameAttribute()
    {
        return explode(' ', $this->attributes['name'])[1] ?? '';
    }

}
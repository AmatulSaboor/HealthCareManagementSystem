<?php

namespace App\Models;

use App\Models\Designation;
use App\Models\Education;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['education_id', 'designation_id', 'specialization_id', 'experience', 'dob', 'gender', 'image_link', 'start_time', 'end_time', 'conusltaion_fee', 'isActive', 'user_id'];

    public function education()
    {
        return $this->belongsTo(Education::class);
    }
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function doctorWorkingDays()
    {
        return $this->hasMany(DoctorWorkingDay::class);
    }
}
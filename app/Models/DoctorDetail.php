<?php

namespace App\Models;

use App\Models\Designation;
use App\Models\Education;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorDetail extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'education_id', 'designation_id', 'specialization_id', 'experience', 'dob', 'gender', 'image_link', 'working_days', 'start_time', 'end_time', 'charges', 'isActive', 'user_id'];

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
}

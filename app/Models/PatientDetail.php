<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class PatientDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'dob', 'gender', 'image_link', 'weight', 'height', 'address', 'phone_number', 'city', 'allergies', 'is_BP_patient', 'is_heart_patient'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageLinkAttribute($image_link)
    {
        return Storage::url($image_link);
    }
}
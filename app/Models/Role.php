<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    const ROLE_ADMIN = 1;
    const ROLE_DOCTOR = 2;
    const ROLE_PATIENT = 3;
    protected $fillable = ['role_name'];
}
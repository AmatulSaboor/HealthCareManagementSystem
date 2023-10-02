<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPatientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'dob' => 'nullable|date|after:' . now()->subYears(100)->format('Y-m-d') . '|before:' . now(),
            'gender' => '',
            'phone_number' => 'required',
            'weight' => 'required',
            'height' => 'required',
            'allergies' => 'required',
            'image_link' => 'nullable|image|mimes:jpeg,jpg,png,gif',
        ];
    }
}
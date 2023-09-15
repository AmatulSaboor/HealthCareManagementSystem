<?php

namespace App\Http\Requests;

use App\Rules\PasswordComplexityRule;
use Illuminate\Foundation\Http\FormRequest;

class AddDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => ['required', 'min:8', new PasswordComplexityRule],
            'password_confirmation' => 'required|same:password',
            'education_id' => 'integer',
            'designation_id' => 'required|integer',
            'specialization_id' => 'required|integer',
            'experience' => 'nullable|integer|min:0',
            'dob' => 'nullable|date|after:'. now()->subYears(80)->format('Y-m-d').'|before:'. now()->subYears(20)->format('Y-m-d'),
            'gender' => '',
            'image_link' => 'nullable|string',
            'working_days' => 'required|array',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'conusltaion_fee' => 'required|integer|between:500,5000'
        ];
    }
    public function messages()
    {
        return [
            'experience.integer' => 'The experience must be in years',
            'end_time.after' => 'End time must be after start time',
            'working_days.required' => 'Select at least 1 working day',
            'designation_id.required' => 'The designation is required',
            'specialization_id.required' => 'The specialization is required',
            'conusltaion_fee.integer' => 'The consultaion fee must be a number',
            'dob.after' => 'The date of birth must be after 1943',
            'dob.before' => 'The date of birth must be before 2003',
        ];
    }
}
<?php

namespace App\Http\Requests;

use App\Rules\PasswordComplexityRule;
use Illuminate\Foundation\Http\FormRequest;

class AddEditDoctorRequest extends FormRequest
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
            'first_name' => 'required|',
            'last_name' => 'required|',
            'email' => 'required|email',
            'password' => ['required', 'min:8', new PasswordComplexityRule],
            'confirm-password' => 'required|same:password',
            'education_id' => 'required|',
            'designation_id' => 'required|',
            'specialization_id' => 'required|',
            'experience' => 'numeric',
            'dob' => '',
            'gender' => '',
            'image_link' => '',
            'working_days' => 'required|',
            'start_time' => 'required|',
            'end_time' => 'required|',
            'charges' => ''
        ];
    }
}
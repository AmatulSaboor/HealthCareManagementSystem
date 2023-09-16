<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleAppointmentRequest extends FormRequest
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
            'field_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'appointment_date' => 'required|date|after:now|before:'. now()->addMonths(3)->format('Y-m-d'),
            'appointment_time' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'field_id.required' => 'Please choose field',
            'doctor_id.required' => 'Please choose doctor',
            'appointment_date.after' => 'Appointment date should be after today',
            'appointment_date.before' => 'Appointment date should be within three months',
            'appointment_time' => 'required',
        ];
    }
}
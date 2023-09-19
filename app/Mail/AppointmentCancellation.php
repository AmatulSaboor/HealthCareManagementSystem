<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentCancellation extends Mailable
{
    use Queueable, SerializesModels;

    public $doctor_name;
    public $appointment_date;
    public $appointment_time;
    public $patient;
    public function __construct(User $patient, $doctor_name, $appointment_date, $appointment_time)
    {
        $this->patient = $patient;
        $this->doctor_name = $doctor_name;
        $this->appointment_date = $appointment_date;
        $this->appointment_time = $appointment_time;
    }

    public function build()
    {
        return $this->view('email/cancellation_email');
    }
}
<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $patient;
    public function __construct(Appointment $appointment, User $patient)
    {
        $this->patient = $patient;
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->view('email/confirmation_email');
    }
}
<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationEmail;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Mail;

class EmailController extends Controller
{
    public function send_mail($id)
    {
        $patient = Auth::user();
        $patient_email = Auth::user()->email;
        $appointment = Appointment::find($id);
        // dd($patient);
        Mail::to([$patient_email])->send(new ConfirmationEmail($appointment, $patient));
        return redirect('appointment');
    }
}
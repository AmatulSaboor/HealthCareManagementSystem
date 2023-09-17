<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use Exception;
use Illuminate\Support\Facades\Auth;
use Mail;

class EmailController extends Controller
{
    public function send_mail($id)
    {
        try{
            $patient = Auth::user();
            $patient_email = Auth::user()->email;
            $appointment = Appointment::find($id);
            // dd($patient);
            Mail::to([$patient_email])->send(new AppointmentConfirmation($appointment, $patient));
            return redirect('appointment')->with(['sent_email_msg' => 'Your appointment has been booked and a confirmation email has been sent']);
        }catch(Exception $e){
            return redirect('appointment')->with(['sent_email_msg' => 'Your appointment has been booked but there was an error in sending confirmation email']);
        }
    }
}
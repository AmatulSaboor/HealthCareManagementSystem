<?php

namespace App\Http\Controllers;

use Mail;
use Exception;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\AppointmentConfirmation;
use App\Mail\AppointmentCancellation;

class EmailController extends Controller
{
    public function send_confirmation_mail($id)
    {
        try{
            $patient = Auth::user();
            $patient_email = Auth::user()->email;
            $appointment = Appointment::find($id);
            Mail::to([$patient_email])->send(new AppointmentConfirmation($appointment, $patient));
            return redirect('appointment')->with(['sent_email_msg' => 'Your appointment has been booked and a confirmation email has been sent']);
        }catch(Exception $e){
            return redirect('appointment')->with(['sent_email_msg' => 'Your appointment has been booked but there was an error in sending confirmation email']);
        }
    }
    public function send_cancellation_mail(Request $request)
    {
        try{
            $data = $request->query();
            $patient = User::find($data['patient_id']);
            $doctor = User::find($data['doctor_id']);
            $doctor_name = $doctor->name;
            Mail::to([$patient->email])->send(new AppointmentCancellation($patient, $doctor_name, $data['date'], $data['time']));
            return redirect('appointment_lists')->with(['sent_email_msg' => 'The appointment has been cancelled and an email has been sent to the patient']);
        }catch(Exception $e){
            return redirect('appointment_lists')->with(['sent_email_msg' => 'The appointment has been cancelled but there was an error in sending email']);
        }
    }
}
<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Role;
use App\Models\User;
use Exception;

class AdminController extends Controller
{
    public function index()
    {
        try {
            return view('admin/admin');
        } catch (Exception $e) {
            return redirect('admin/admin')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function get_appointments()
    {
        try {
            $appointments = Appointment::orderBy('appointment_date', 'asc')->paginate(3);
            return view('admin/show_appointments')->with(['appointments' => $appointments]);
        } catch (Exception $e) {
            return redirect('admin')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function delete_appointment($id)
    {
        try {
            $appointment = Appointment::find($id);
            $appointmentData = [
                'date' => $appointment->appointment_date,
                'time' => $appointment->appointment_time,
                'doctor_id' => $appointment->doctor_id,
                'patient_id' => $appointment->patient_id,
            ];
            // $copyAppointment = clone $appointment;
            $appointment->delete();
            $abc = http_build_query( $appointmentData);
            // dd($abc);
            // dd($copyAppointment);
            return redirect('/send_cancellation_mail?' .$abc);
            // return redirect('appointment_lists')->with(['success_message' => "appointment cancelled suceessfuly"]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect('appointment_lists')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function get_patients()
    {
        try {
            $patients = User::where('role_id', Role::ROLE_PATIENT)->orderBy('name', 'asc')->paginate(3);
            return view('admin/show_patients')->with(['patients' => $patients]);
        } catch (Exception $e) {
            return redirect('admin')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function show_patient($id)
    {
        try {
            $patient = User::find($id);
            return view('admin/show_patient_profile')->with(['patient' => $patient]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect('appointment_lists')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
}
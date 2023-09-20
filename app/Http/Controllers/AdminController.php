<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Appointment;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $response['patient_count'] = User::where('role_id', Role::ROLE_PATIENT)->count();
            $response['doctor_count'] = User::where('role_id', Role::ROLE_DOCTOR)->count();
            $response['appointment_count'] = Appointment::all()->count();
            return view('admin/admin')->with('response', $response);
        } catch (Exception $e) {
            return view('errors.admin_error')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    //  -------------- get all appointments list ---------------- //
    public function get_appointments()
    {
        try {
            $appointments = Appointment::orderBy('appointment_date', 'asc')->paginate(5);
            return view('admin/show_appointments')->with(['appointments' => $appointments]);
        } catch (Exception $e) {
            return redirect('/admin')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    //  -------------- delete appointment and send email ---------------- //
    public function delete_appointment($id)
    {
        try {
            $appointment = Appointment::find($id);
            $appointment_data = [
                'date' => $appointment->appointment_date,
                'time' => $appointment->appointment_time,
                'doctor_id' => $appointment->doctor_id,
                'patient_id' => $appointment->patient_id,
            ];
            $appointment->delete();
            $query_string = http_build_query($appointment_data);
            return redirect('/send_cancellation_mail?' . $query_string);
        } catch (Exception $e) {
            return redirect('appointment_lists')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    //  -------------- get all patients list ---------------- //
    public function get_patients()
    {
        try {
            $patients = User::where('role_id', Role::ROLE_PATIENT)->paginate(5);
            return view('admin/show_patients')->with(['patients' => $patients]);
        } catch (Exception $e) {
            return redirect('admin')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    //  -------------- get patient by id ---------------- //
    public function show_patient($id)
    {
        try {
            $patient = User::find($id);
            return view('admin/show_patient_profile')->with(['patient' => $patient]);
        } catch (Exception $e) {
            return redirect('appointment_lists')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
}
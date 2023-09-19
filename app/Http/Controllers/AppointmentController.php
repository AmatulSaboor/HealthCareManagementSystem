<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleAppointmentRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Specialization;
use App\Models\DoctorDetail;
use App\Models\Appointment;
use App\Models\User;
use DateInterval;
use Exception;
use DateTime;

class AppointmentController extends Controller
{
    public function index()
    {
        try {
            $appointments = Appointment::where(['patient_id' => Auth::user()->id])->orderBy('appointment_date', 'asc')->paginate(5);
            return view('patient/show_appointments')->with(['appointments' => $appointments]);
        } catch (Exception $e) {
            return redirect('patient')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function create()
    {
        try {
            $specializations = Specialization::orderBy('name', 'asc')->get();
            return view('patient/schedule_appointment')->with(['fields' => $specializations]);
        } catch (Exception $e) {
            return redirect('appointment')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function store(ScheduleAppointmentRequest $request)
    {
        try {
            $check_appointment = Appointment::where(['doctor_id' => $request['doctor_id'], 'appointment_date' => $request['appointment_date'], 'appointment_time' => $request['appointment_time']])->get();
            if (count($check_appointment) <= 0) {
                $request->merge(['patient_id' => Auth::id()]);
                $appointment = Appointment::create($request->all());
                return redirect('/send_confirmation_mail' . '/' . $appointment->id);
            } else {
                return redirect('appointment/create')->with(['add_appointment_err_msg' => 'This appointment is already booked, try some different date and time']);
            }
        } catch (Exception $e) {
            return redirect('appointment/create')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function edit($id)
    {
        try {
            $appointment = Appointment::find($id);
            $specializations = Specialization::orderBy('name', 'asc')->get();
            return view('patient/reschedule_appointment')->with(['fields' => $specializations, 'appointment' => $appointment]);
        } catch (Exception $e) {
            return redirect('appointment')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function update(ScheduleAppointmentRequest $request, $id)
    {
        try {
            $check_appointment = Appointment::where(['doctor_id' => $request['doctor_id'], 'appointment_date' => $request['appointment_date'], 'appointment_time' => $request['appointment_time']])->get();
            if (count($check_appointment) <= 0) {
                $request->merge(['patient_id' => Auth::id()]);
                $appointment = Appointment::find($id);
                $appointment->update($request->all());
                return redirect('appointment');
            } else {
                return redirect('appointment/' . $id . '/edit')->with(['edit_appointment_err_msg' => 'The appointment is already booked']);
            }
        } catch (Exception $e) {
            return redirect('appointment/' . $id . '/edit')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function destroy($id)
    {
        try {
            $appointment = Appointment::find($id);
            $appointment->delete();
            return redirect('appointment');
        } catch (Exception $e) {
            return redirect('appointment')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function get_time_intervals_by_doctor_id($doctor_id)
    {
        try {
            $intervals = [];
            $doctor_times = DoctorDetail::where('user_id', $doctor_id)->select('start_time', 'end_time')->first();
            $start_time = new DateTime($doctor_times['start_time']);
            $end_time = new DateTime($doctor_times['end_time']);
            $current_time = $start_time;
            while ($current_time <= $end_time) {
                $intervals[] = $current_time->format('h:ia');
                $current_time->add(new DateInterval('PT30M'));
            }
            return $intervals;
        } catch (Exception $e) {
            return redirect('appointment/create')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function get_doctors_by_field($field_id)
    {
        try {
            $doctors = DoctorDetail::where('specialization_id', $field_id)->with('user')->get();
            // $doctors = $doctors->sortBy('user.name');
            return response()->json($doctors);
        } catch (Exception $e) {
            return redirect('appointment/create')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function get_working_days_by_doctor_id($doctor_id)
    {
        try {
            $days = User::find($doctor_id)->doctorWorkingDays->pluck('day_name');
            return response()->json($days);
        } catch (Exception $e) {
            return redirect('appointment/create')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
}
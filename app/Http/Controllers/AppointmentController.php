<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleAppointmentRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorWorkingDay;
use App\Models\Specialization;
use Illuminate\Http\Request;
use App\Models\DoctorDetail;
use App\Models\Appointment;
use DateInterval;
use Exception;
use DateTime;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $appointments = Appointment::all();
            return view('patient/show_appointments')->with(['appointments' => $appointments]);
        } catch (Exception $e) {

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $specializations = Specialization::all();
            return view('patient/schedule_appointment')->with(['fields' => $specializations]);
        } catch (Exception $e) {
            return redirect('patient/schedule_appointment')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleAppointmentRequest $request)
    {
        try {
            $check_appointment = Appointment::where(['doctor_id' => $request['doctor_id'], 'appointment_date' => $request['appointment_date'], 'appointment_time' => $request['appointment_time']])->get();
            if (count($check_appointment) <= 0) {
                $request->merge(['patient_id' => Auth::id()]);
                Appointment::create($request->all());
                return redirect('appointment');
            } else {
                return redirect('appointment/create')->with(['error_message' => 'the appointment is already booked']);
            }
        } catch (Exception $e) {
            return redirect('appointment/create')->with(['error_message' => $e]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    public function update(ScheduleAppointmentRequest $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
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
            return redirect('appointment/create')->with(['error_message' => $e]);
        }
    }


    public function get_doctors_by_field($field_id)
    {
        try {
            $doctors = DoctorDetail::where('specialization_id', $field_id)->with('user')->get();
            // dd($doctors);
            return response()->json($doctors);
        } catch (Exception $e) {
            return redirect('appointment/create')->with(['error_message' => $e]);
        }
    }

    public function get_working_days_by_doctor_id($doctor_id)
    {
        try {
            $days = DoctorWorkingDay::where('user_id', $doctor_id)->pluck('day');
            return response()->json($days);
        } catch (Exception $e) {
            return redirect('appointment/create')->with(['error_message' => $e]);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleAppointmentRequest;
use App\Models\Appointment;
use App\Models\Specialization;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return view('patient/patient')->with(['appointments' => $appointments]);
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
            return view('patient/book_appointment')->with(['fields' => $specializations, 'doctors' => []]);
        } catch (Exception $e) {
            return redirect('patient/book_appointment')->with(['error_message' => 'something went wrong']);
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
                return redirect('patient_dashboard');
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
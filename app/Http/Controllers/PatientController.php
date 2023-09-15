<?php

namespace App\Http\Controllers;

use App\Models\DoctorDetail;
use App\Models\DoctorWorkingDay;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('patient/patient');
    }

    public function get_time_intervals_by_doctor_id($doctor_id)
    {
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
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_appointment()
    {
        // try {
        //     $specializations = Specialization::all();
        //     return view('patient/book_appointment')->with(['fields' => $specializations, 'doctors' => []]);
        // } catch (Exception $e) {
        //     return redirect('patient/book_appointment')->with(['error_message' => 'something went wrong']);
        // }
    }

    public function get_doctors_by_field($field_id)
    {
        try {
            $doctors = DoctorDetail::where('specialization_id', $field_id)->with('user')->get();
            // dd($doctors);
            return response()->json($doctors);
        } catch (Exception $e) {

        }
    }

    public function get_working_days_by_doctor_id($doctor_id)
    {
        try {
            $days = DoctorWorkingDay::where('user_id', $doctor_id)->pluck('day');
            return response()->json($days);
        } catch (Exception $e) {

        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
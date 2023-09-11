<?php

namespace App\Http\Controllers;

use App\Models\DoctorDetail;
use App\Models\Specialization;
use App\Models\User;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_appointment()
    {
        try {
            $specializations = Specialization::all();
            
            return view('patient/book_appointment')->with(['fields' => $specializations, 'doctors' => []]);
        } catch (Exception $e) {
            return redirect('patient/book_appointment')->with(['error_message' => 'something went wrong']);
        }
    }

    public function get_doctor_by_field($field_id)
    {
        try{
            $doctors = DoctorDetail::where('specialization_id', $field_id)->get();
            // dd($doctors);
            return response()->json($doctors);
        }catch(Exception $e){

        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_appointment(Request $request)
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
<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditPatientRequest;
use Illuminate\Support\Facades\DB;
use App\Models\PatientDetail;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class PatientController extends Controller
{
    public function index()
    {
        try {
            return view('patient/patient');
        } catch (Exception $e) {
            return redirect('/patient')->with(['error_message', 'something went wrong, please refresh the page and try again']);
        }
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        try {
            $patient = User::find($id);
            return view('patient/show_patient_profile')->with(['patient' => $patient]);
        } catch (Exception $e) {
            return redirect('patient')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function edit($id)
    {
        try {
            $patient = User::find($id);
            return view('patient/edit_patient_profile')->with(['patient' => $patient]);
        } catch (Exception $e) {
            return redirect('patient' . '/' . $id)->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function update(EditPatientRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $patient = User::find($id);
            $patient->update(['name' => $request['first_name'] . ' ' . $request['last_name']]);
            $request['user_id'] = $id;
            PatientDetail::where(['user_id' => $id])->first()->update($request->all());
            DB::commit();
            return redirect('patient/' . $id);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('patient/' . $id . '/edit')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function destroy($id)
    {
        //
    }
}
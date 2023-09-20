<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Role;
use App\Models\Education;
use App\Models\Appointment;
use App\Models\Designation;
use App\Models\DoctorDetail;
use App\Models\Specialization;
use Illuminate\Support\Carbon;
use App\Models\DoctorWorkingDay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddDoctorRequest;
use App\Http\Requests\EditDoctorRequest;

class DoctorController extends Controller
{
    private $start_times = ['09:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM'];
    private $end_times = ['11:00 AM', '12:00 PM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM', '06:00 PM'];

    public function index()
    {
        try {
            $doctors = User::where('role_id', Role::ROLE_DOCTOR)->paginate(5);
            return view('admin/show_doctors')->with(['doctors' => $doctors]);
        } catch (Exception $e) {
            return redirect('/admin')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function create()
    {
        try {
            $specializations = Specialization::orderBy('name', 'asc')->get();
            $designation = Designation::orderBy('name', 'asc')->get();
            $edcucations = Education::orderBy('name', 'asc')->get();
            return view('admin/create_doctor')->with([
                'start_times' => $this->start_times,
                'end_times' => $this->end_times,
                'educations' => $edcucations,
                'designations' => $designation,
                'specializations' => $specializations
            ]);
        } catch (Exception $e) {
            return redirect('/admin')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function store(AddDoctorRequest $request)
    {
        try {
            DB::beginTransaction();
            // -------- add doctor in user table ---------------------- //
            $request->merge(['role_id' => Role::ROLE_DOCTOR, 'name' => $request['first_name'] . ' ' . $request['last_name']]);
            $request['password'] = Hash::make($request['password']);
            $user = $request->only('role_id', 'name', 'email', 'password');
            $doctor = User::create($user);

            // -------- add doctor in doctor detail table ---------------------- //
            $request['user_id'] = $doctor->id;
            $request['start_time'] = Carbon::createFromFormat('h:ia', $request['start_time']);
            $request['end_time'] = Carbon::createFromFormat('h:ia', $request['end_time']);
            DoctorDetail::create($request->all());

            // -------- add doctor working days in working day table ---------------------- //
            foreach ($request['working_days'] as $doctor_day) {
                DoctorWorkingDay::create(['user_id' => $doctor->id, 'day' => $doctor_day]);
            }
            DB::commit();
            return redirect('/doctor')->with(['doctor_add_success_msg' => "Doctor added suceessfuly"]);
            ;
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/doctor/create')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        try {
            $doctor = User::find($id);
            $specializations = Specialization::orderBy('name', 'asc')->get();
            $designation = Designation::orderBy('name', 'asc')->get();
            $edcucations = Education::orderBy('name', 'asc')->get();
            return view('admin/edit_doctor')->with([
                'doctor' => $doctor,
                'educations' => $edcucations,
                'designations' => $designation,
                'specializations' => $specializations,
                'start_times' => $this->start_times,
                'end_times' => $this->end_times
            ]);
        } catch (Exception $e) {
            return redirect('doctor')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function update(EditDoctorRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            // -------- update doctor name in user table ---------------------- //
            $doctor = User::find($id);
            $doctor->update(['name' => $request['first_name'] . ' ' . $request['last_name']]);

            // -------- update doctor in doctor detail table ---------------------- //
            $request['user_id'] = $id;
            $request['start_time'] = Carbon::createFromFormat('h:ia', $request['start_time']);
            $request['end_time'] = Carbon::createFromFormat('h:ia', $request['end_time']);
            DoctorDetail::where(['user_id' => $id])->first()->update($request->all());

            // -------- delete and then update doctor working days in working day table ----------- //
            foreach ($doctor->doctorWorkingDays as $doctor_day) {
                $doctor_day->delete();
            }
            foreach ($request['working_days'] as $doctor_day) {
                DoctorWorkingDay::create(['user_id' => $doctor->id, 'day' => $doctor_day]);
            }
            DB::commit();
            return redirect('/doctor');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/doctor/' . $id . '/edit')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function destroy($id)
    {
        try {
            $doctor = User::find($id);
            $appointments = Appointment::where('doctor_id', $doctor->id)->where('appointment_date', '>', now())->get();

            //------------------- before delete, make sure that the doctor has not any upcoming appointments ----------- //
            if (count($appointments) <= 0) {
                DB::beginTransaction();
                if ($doctor) {
                    $doctor->doctorDetail()->delete();
                    $doctor->doctorWorkingDays()->delete();
                    $doctor->delete();
                }
                DB::commit();
                return redirect('doctor');
            } else {
                return redirect('doctor')->with(['doctor_delete_err_msg' => "You can't delete doctor, becaushe he/she has upcoming appointments"]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('doctor')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function doctor()
    {
        try {
            $response['upcoming_appointments'] = Appointment::where([['appointment_date', '>', now()],['doctor_id', '=', Auth::id()]])->count();
            $response['prev_appointments'] = Appointment::where([['appointment_date', '<', now()],['doctor_id', '=', Auth::id()]])->count();
            $response['todays_appointments'] = Appointment::where([['appointment_date', '=' , now()],['doctor_id', '=', Auth::id()]])->count();
            return view('doctor/doctor')->with('response', $response);
        } catch (Exception $e) {
            return view('errors.doctor_error')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function get_patient($id)
    {
        try {
            $patient = User::find($id);
            return view('doctor/show_patient_profile')->with(['patient' => $patient]);
        } catch (Exception $e) {
            return redirect('doctor_appointments')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function get_appointments()
    {
        try {
            $appointments = Appointment::where(['doctor_id' => Auth::user()->id])->orderBy('appointment_date', 'asc')->paginate(3);
            return view('doctor/show_appointments')->with(['appointments' => $appointments]);
        } catch (Exception $e) {
            return redirect('doctor_dashboard')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
}
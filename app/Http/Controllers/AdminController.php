<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Role;
use App\Models\Education;
use App\Models\Designation;
use App\Models\DoctorDetail;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DoctorWorkingDay;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddDoctorRequest;
use App\Http\Requests\EditDoctorRequest;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private $start_times = ['09:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM'];
    private $end_times = ['11:00 AM', '12:00 PM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM', '06:00 PM'];

    public function admin()
    {
        try {
            return view('admin/admin');
        } catch (Exception $e) {
            return redirect('admin/admin')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function index()
    {
        try {
            $doctors = User::where('role_id', 2)->paginate(3);
            // map working days here may be
            return view('admin/show_doctors')->with(['doctors' => $doctors]);
        } catch (Exception $e) {
            dd($e);
            return redirect('/doctors')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function create()
    {
        try {
            $specializations = Specialization::all();
            $designation = Designation::all();
            $edcucations = Education::all();
            return view('admin/create_doctor')->with([
                'start_times' => $this->start_times,
                'end_times' => $this->end_times,
                'educations' => $edcucations,
                'designations' => $designation,
                'specializations' => $specializations
            ]);
        } catch (Exception $e) {
            return redirect('admin/admin_dashboard')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
    public function store(AddDoctorRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->merge(['role_id' => Role::ROLE_DOCTOR, 'name' => $request['first_name'] . ' ' . $request['last_name']]);
            $request['password'] = Hash::make($request['password']);
            $user = $request->only('role_id', 'name', 'email', 'password');
            $doctor = User::create($user);
            $request['user_id'] = $doctor->id;
            $request['start_time'] = Carbon::createFromFormat('h:ia', $request['start_time']);
            $request['end_time'] = Carbon::createFromFormat('h:ia', $request['end_time']);
            foreach ($request['working_days'] as $doctor_day) {
                DoctorWorkingDay::create(['user_id' => $doctor->id, 'day' => $doctor_day]);
            }
            DoctorDetail::create($request->all());
            DB::commit();
            return redirect('/doctor')->with(['success_message' => "Doctor added suceessfuly"]);;
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect('/doctor')->with(['error_message' => $e->getMessage()]);
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
            $specializations = Specialization::all();
            $designation = Designation::all();
            $edcucations = Education::all();
            return view('admin/edit_doctor')->with([
                'doctor' => $doctor,
                'educations' => $edcucations,
                'designations' => $designation,
                'specializations' => $specializations,
                'start_times' => $this->start_times,
                'end_times' => $this->end_times
            ]);
        } catch (Exception $e) {
            return redirect('admin/admin')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }

    public function update(EditDoctorRequest $request, $id)
    {
        try {
            // dd('in here');
            DB::beginTransaction();
            $doctor = User::find($id);
            $doctor->update(['name' => $request['first_name'] . ' ' . $request['last_name']]);
            $request['user_id'] = $id;
            $request['start_time'] = Carbon::createFromFormat('h:ia', $request['start_time']);
            $request['end_time'] = Carbon::createFromFormat('h:ia', $request['end_time']);
            foreach ($doctor->doctorWorkingDays as $doctor_day) {
                $doctor_day->delete();
            }
            foreach ($request['working_days'] as $doctor_day) {
                DoctorWorkingDay::create(['user_id' => $doctor->id, 'day' => $doctor_day]);
            }
            DoctorDetail::where(['user_id' => $id])->first()->update($request->all());
            DB::commit();
            return redirect('/doctor');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect('/doctor')->with(['error_message' => $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        try {
            $doctor = User::find($id);
            dd($doctor->doctorAppointments);
            $upcoming_appointments = $doctor->appointments;
            if (count($upcoming_appointments) <= 0) {
                DB::beginTransaction();
                if ($doctor) {
                    $doctor->doctorDetail()->delete();
                }
                $doctor->delete();
                DB::commit();
                return redirect('doctor')->with(['success_message' => "Doctor deleted suceessfuly"]);
            } else {
                return redirect('doctor')->with(['error_message' => "You can't delete doctor, becaushe he/she has appointments"]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('doctor')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
}
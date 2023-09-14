<?php
namespace App\Http\Controllers;

use App\Http\Requests\AddEditDoctorRequest;
use App\Models\Designation;
use App\Models\DoctorDetail;
use App\Models\DoctorWorkingDay;
use App\Models\Education;
use App\Models\Role;
use App\Models\Specialization;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        try {
            return view('admin/admin');
        } catch (Exception $e) {
            return redirect('admin/admin_dashboard')->with(['error_message' => 'something went wrong']);
        }
    }
    public function index()
    {
        try {
            $doctors = User::where('role_id', 2)->get();
            return view('admin/show_doctors')->with(['doctors' => $doctors]);
        } catch (Exception $e) {
            return redirect('admin/show_doctors')->with(['error_message' => 'something went wrong']);
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
            $designation = Designation::all();
            $edcucations = Education::all();
            return view('admin/create_doctor')->with(['educations' => $edcucations, 'designations' => $designation, 'specializations' => $specializations]);
        } catch (Exception $e) {
            return redirect('admin/admin_dashboard')->with(['error_message' => 'something went wrong']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddEditDoctorRequest $request)
    {
        try {
            // dd($request);
            DB::beginTransaction();
            $request->merge(['role_id' => Role::ROLE_DOCTOR, 'name' => $request['first_name'] . ' ' . $request['last_name']]);
            $user = $request->only('role_id', 'name', 'email', 'password');
            // dd($user);
            // $user['name'] = $request['first_name'] . ' ' . $request['last_name'];
            // $user['email'] = $request['email'];
            // $user['password'] = Hash::make($request['password']);
            // $user['role_id'] = Role::ROLE_DOCTOR;
            $doctor = User::create($user);
            $request['user_id'] = $doctor->id;
            foreach ($request['working_days'] as $doctor_day) {
                DoctorWorkingDay::create(['user_id' => $doctor->id, 'day' => $doctor_day]);
            }
            // dd(DoctorWorkingDay::all());
            $request['working_days'] = '';
            DoctorDetail::create($request->all());
            // dd('in here');
            DB::commit();
            return redirect('/doctor');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/doctor')->with(['error_message' => $e->getMessage()]);
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
        try {
            $doctor = User::find($id);
            $specializations = Specialization::all();
            $designation = Designation::all();
            $edcucations = Education::all();
            return view('admin/edit_doctor')->with(['doctor' => $doctor, 'educations' => $edcucations, 'designations' => $designation, 'specializations' => $specializations]);
        } catch (Exception $e) {
            return redirect('admin/admin')->with(['error_message' => 'something went wrong']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddEditDoctorRequest $request, $id)
    {
        try {
            $doctor = User::find($id);
            $doctor->doctorDetail->save($request->all());
            // foreach ($request['working_days'] as $doctor_day) {
            //     DoctorWorkingDay::create(['user_id' => $doctor->id, 'day' => $doctor_day]);
            // }

            return redirect('admin/admin_dashboard');
        } catch (Exception $e) {
            return redirect('admin/admin')->with(['error_message' => 'something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $doctor = User::find($id);
            // dd($doctor);
            // dd($doctor->doctorDetail);
            if ($doctor) {
                $doctor->doctorDetail()->delete();
            }
            // dd($doctor);
            // dd($doctor->doctorDetail());
            $doctor->delete();
            DB::commit();
            return redirect('admin/admin_dashboard');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('admin/admin')->with(['error_message' => 'something went wrong']);
        }
    }
}
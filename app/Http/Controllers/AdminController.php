<?php
namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\DoctorDetail;
use App\Models\Education;
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
    public function index()
    {
        try {
            $doctors = User::where('role_id', 2)->get();
            return view('admin/admin')->with(['doctors' => $doctors]);
        } catch (Exception $e) {
            return redirect('admin/admin_dashboard')->with(['error_message' => 'something went wrong']);
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
    public function store(Request $request)
    {
        try {
            dd($request);
            DB::beginTransaction();
            $input1['name'] = $request['first_name'] . ' ' . $request['last_name'];
            $input1['email'] = $request['email'];
            $input1['password'] = Hash::make($request['password']);
            $input1['role_id'] = $request[2];
            $doctor = User::create($input1);

            $request['user_id'] = $doctor->id;
            DoctorDetail::create($request->all());
            DB::commit();
            return redirect('admin/admin_dashboard');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/create_doctor')->with(['error_message' => 'something went wrong']);
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
    public function update(Request $request, $id)
    {
        try {
            $doctor = User::find($id);
            $doctor->doctorDetail->update($request->all());
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
        try{
            DB::beginTransaction();
            $doctor = User::find($id);
            // dd($doctor);
            // dd($doctor->doctorDetail);
            if($doctor){
                $doctor->doctorDetail()->delete();
            }
            // dd($doctor);
            // dd($doctor->doctorDetail());
            $doctor->delete();
            DB::commit(); 
            return redirect('admin/admin_dashboard');
        }catch(Exception $e){
            DB::rollBack();
            return redirect('admin/admin')->with(['error_message' => 'something went wrong']);
        }
    }
}
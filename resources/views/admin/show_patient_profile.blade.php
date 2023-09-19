@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ url('css/login.css') }}"> 
@endpush
@section('content')
<div class="container index">

    <!-- Error Message -->
    @if(session()->get('error_message'))
    <div class="alert alert-danger">{{session()->get('error_message')}}</div>
    @endif

    <!-- Patient Profile -->
    <h4>Your Profile</h4>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-7">

                    <!-- Stepper -->
                    <ul class="nav nav-tabs" id="stepper-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="step1-tab" data-toggle="tab" href="#step1" class="step">Account Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2" class="step">Personal Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="step3-tab" data-toggle="tab" href="#step3" class="step">Health Info</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="stepper-content">

                        <!-- Account Info Tab -->
                        <div class="tab-pane fade show active" id="step1">
                            <h3 class="my-2 text-center">Account Info</h3>
                            <div class="form-group">
                                <label>Name : {{$patient->name}}</label>
                            </div>
                            <div class="form-group">
                                <label>Email : {{$patient->email}}</label>
                            </div>
                        </div>

                        <!-- Personal Info Tab -->
                       <div class="tab-pane fade" id="step2">
                        <h3 class="my-2 text-center">Personal Info</h3>
                            <div class="form-group">
                                <label>D.O.B. {{$patient->patientDetail->dob}}</label>
                            </div>
                            <div class="form-group">
                                <label >Phone Number : {{$patient->patientDetail->phone_number}} </label>
                            </div>
                            <div class="form-group">
                                <label>Address: {{$patient->patientDetail->address}} </label>
                            </div
                            <div class="form-group">
                                <label>City: {{$patient->patientDetail->city}} </label>
                            </div>
                            <div class="form-group">
                                <label>Gender : {{$patient->patientDetail->gender}} </label>
                            </div>
                        </div>

                        <!-- Health Info Tab -->
                        <div class="tab-pane fade" id="step3">
                            <h3 class="my-2 text-center">Health Info</h3>
                            <div class="form-group">
                                <label>Weight : {{$patient->patientDetail->weight}} kgs</label>
                            </div>
                            <div class="form-group">
                                <label>Height : {{$patient->patientDetail->height }}</label>
                            </div>
                            <div class="form-group">
                                <label>Allergies : {{$patient->patientDetail->allergies }}</label>
                            </div>
                            <div class="form-group">
                                <label>BP Patient : {{$patient->patientDetail->is_BP_patient == true ? 'Yes' : 'No'}}</label>
                            </div>
                            <div class="form-group">
                                <label>Heart Patient : {{$patient->patientDetail->is_heart_patient == true ? 'Yes' : 'No' }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-center align-items-center">
                    <img src="{{'/images/add-doctor.png'}}" style="height:400px">
                </div>
            </div> 
        </div>
    <div>
        <button class="btn btn-primary mt-3 prev-btn" id="prevBtn" onclick="prevStep()">Previous</button>
        <button class="btn btn-primary mt-3 ml-3 next-btn" id="nextBtn" onclick="nextStep()">Next</button>
    </div>
</div>
@push('js')
<script src="{{asset('js/stepper.js')}}"></script>
@endpush
@endsection
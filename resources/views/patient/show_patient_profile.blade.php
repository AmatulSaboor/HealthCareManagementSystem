@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ url('css/login.css') }}"> 

@endpush
@section('content')
<div class="container" >

    <!-- Error Message -->
    @if(session()->get('error_message'))
    <div class="alert alert-danger">{{session()->get('error_message')}}</div>
    @endif

    <!-- Patient Profile -->
    <h4 class="text-center font-weight-bold">Your Profile</h4>
    <section class="bg-light">
        <div class="container">
            <div class="main-body">
        

            <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                        <h4>{{$patient->name}}</h4>
                        <p class="text-secondary mb-1">{{$patient->email}}</p>
                    </div>
                    </div>
                </div>
                </div>
               
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->name}}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->email}}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Date of Birth</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->patientDetail->dob}}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Mobile</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->patientDetail->phone_number}}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->patientDetail->address}}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">City</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->patientDetail->city}}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Gender</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->patientDetail->gender}}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Weight</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->patientDetail->weight}}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Height</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->patientDetail->height}}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Allergies</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->patientDetail->allergies}}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Allergies</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->patientDetail->is_BP_patient == true ? 'Yes' : 'No'}}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Allergies</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$patient->patientDetail->is_heart_patient == true ? 'Yes' : 'No' }}
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-primary " target="__blank" href="{{url('patient/'.$patient->id.'/edit')}}">Edit</a>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>

        </div>
    </div>
</section>
    <!-- <div>
        <button class="btn btn-primary mt-3 prev-btn" id="prevBtn" onclick="prevStep()">Previous</button>
        <button class="btn btn-primary mt-3 ml-3 next-btn" id="nextBtn" onclick="nextStep()">Next</button>
        <button class="btn btn-primary mt-3 ml-3 cancel-btn"><a href="{{url('patient/'.$patient->id.'/edit')}}" class="cancel-btn">Edit</a></button>
    </div> -->
</div>
@push('js')
<script src="{{asset('js/stepper.js')}}"></script>
@endpush
@endsection
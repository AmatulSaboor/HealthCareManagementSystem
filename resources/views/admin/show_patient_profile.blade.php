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
    <h4 class="text-center font-weight-bold">{{$patient->name}} Profile</h4>
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
                                    <div class="col-sm-9 text-secondary">{{$patient->name}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$patient->email}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Age</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">@calculateAge($patient->patientDetail->dob) years</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Gender</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$patient->patientDetail->gender}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Weight</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$patient->patientDetail->weight}} kgs</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Height</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$patient->patientDetail->height}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Allergies</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$patient->patientDetail->allergies}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">BP Patient</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$patient->patientDetail->is_BP_patient == true ? 'Yes' : 'No'}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Heart Patient</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$patient->patientDetail->is_heart_patient == true ? 'Yes' : 'No' }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a class="btn btn-primary " target="__blank" href="{{url('appointment_lists')}}">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@push('js')
<script src="{{asset('js/stepper.js')}}"></script>
@endpush
@endsection
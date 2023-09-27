@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/login.css') }}"> 
@endpush
@section('content')
<div class="container" >

    <!-- Error Message -->
    @if(session()->get('error_message'))
    <div class="alert alert-danger">{{session()->get('error_message')}}</div>
    @endif

    <!-- Doctor Profile -->
    <h4 class="text-center font-weight-bold">My Profile</h4>
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
                                        <h4>{{$doctor->name}}</h4>
                                        <p class="text-secondary mb-1">{{$doctor->email}}</p>
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
                                    <div class="col-sm-9 text-secondary">{{$doctor->name}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$doctor->email}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Age</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">@calculateAge($doctor->doctorDetail->dob) years</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Gender</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$doctor->doctorDetail->gender}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Education</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$doctor->doctorDetail->education->name}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Specialization</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$doctor->doctorDetail->specialization->name}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Designation</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$doctor->doctorDetail->designation->name}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Working Days</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @foreach($doctor->doctorWorkingDays as $doctor_day)
                                        {{$doctor_day->day_name}},
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Timings</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{ date('h:i A', strtotime($doctor->doctorDetail->start_time))}} to {{ date('h:i A', strtotime($doctor->doctorDetail->end_time))}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a class="btn btn-primary " target="__blank" href="{{url('doctor_dashboard')}}">Back</a>
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
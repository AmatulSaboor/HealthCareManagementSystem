@extends('layouts.app')
@push('css')
    <link href="{{ asset('css/table.css')}}" rel="stylesheet">
    <link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container">
    @if(session()->get('error_message'))
    <div class="alert alert-danger">{{session()->get('error_message')}}</div>
    @endif
    <div class="card">
        <div class="card-header text-center"><b>Patients</b></div>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-md-8 col-form-label text-md-right">No of Registered Patients are {{$response['patient_count']}}</label>
                </div>
                <div class="row mb-3">
                    <button class="col-md-8 col-form-label text-md-right"><a href="{{url('patient_lists')}}">Show the list</a></label>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header text-center"><b>Doctors</b></div>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-md-8 col-form-label text-md-right">No of Registered Doctors are {{$response['doctor_count']}}</label>
                </div>
                <div class="row mb-3">
                    <button class="col-md-8 col-form-label text-md-right"><a href="{{url('doctor')}}">Show the list</a></label>
                </div>
                <div class="row mb-3">
                    <button class="col-md-8 col-form-label text-md-right"><a href="{{url('doctor/create')}}">+ Add Doctor</a></label>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header text-center"><b>Appointments</b></div>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-md-8 col-form-label text-md-right">No of Appointments are {{$response['appointment_count']}}</label>
                </div>
                <div class="row mb-3">
                    <button class="col-md-8 col-form-label text-md-right"><a href="{{url('appointment_lists')}}">Show the list</a></label>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    @endpush
    @endsection
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
    <form action="{{url('doctor/create')}}"><button>Add Doctor</button></form>
    <form action="{{url('doctor')}}"><button>Doctors List</button></form>
    <form action="{{url('appointment_lists')}}"><button>Appointments List</button></form>
    <form action="{{url('patient_lists')}}"><button>Patients List</button></form>
</div>
@push('js')
@endpush
@endsection
@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
@if(session()->get('error_message'))
<div class="alert alert-danger">{{session()->get('error_message')}}</div>
@endif
<div class="container">
    <form action="{{url('doctor_appointments')}}"><button>My Appointments</button></form>
</div>
@push('js')
@endpush
@endsection
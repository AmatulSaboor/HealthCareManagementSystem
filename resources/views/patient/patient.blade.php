@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
@if(session()->get('error_message'))
<div class="alert alert-danger">{{session()->get('error_message')}}</div>
@endif
<div class="container index">
    <form action="{{url('patient/'. auth()->id())}}"><button>Show Profile</button></form>
    <form action="{{url('appointment/create')}}"><button>Schedule an Appointment</button></form>
    <form action="{{url('appointment')}}"><button>Appointment List</button></form>
</div>
@push('js')
@endpush
@endsection
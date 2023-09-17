@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<span>{{session()->get('error_message')}}</span>
<div class="container index">
    <form action="{{url('appointment/create')}}"><button>Book an Appointment</button></form>
    <form action="{{url('appointment')}}"><button>Appointment List</button></form>
</div>
@push('js')
@endpush
@endsection
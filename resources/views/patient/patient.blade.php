@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<form action="{{url('create_appointment')}}"><button>Book an Appointment</button></form>
@push('js')
@endpush
@endsection
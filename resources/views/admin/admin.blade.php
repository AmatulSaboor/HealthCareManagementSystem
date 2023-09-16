@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container index">
    <form action="{{url('doctor/create')}}"><button>Add Doctor</button></form>
    <form action="{{url('doctor')}}"><button>Doctors List</button></form>
</div>
@push('js')
@endpush
@endsection
@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container" class ="index">
    <a href="{{ route('doctor.index') }}">Doctor</a>
</div>
@push('js')
@endpush
@endsection
@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<h4>Appointments List</h4>
<form action="{{url('appointment/create')}}"><button>Book an Appointment</button></form>
    <span>{{session()->get('error_message')}}</span>
    <table>
        <tr>
            <th>For</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($appointments as $appointment)
        <tr>
            <td>{{1}}</td>
            <td>{{$appointment->doctorUser->name}}</td>
            <td>{{$appointment->appointment_date}}</td>
            <td>{{$appointment->appointment_time}}</td>
            {{-- <td><a href="{{url('doctor').'/'.$doctor->id.'/edit'}}">Edit</a></td>
            <th>
                <form action="{{url('doctor').'/'.$doctor->id}}" method ="POST"> --}}
                {{-- @csrf
                @method('delete') --}}
                    {{-- <input type="submit" value ="delete"/> --}}
                {{-- </form> --}}
            </th>
        </tr>
        @endforeach
    </table>
@push('js')
@endpush
@endsection
@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<h4>Appointments List</h4>
<form action="{{url('appointment/create')}}"><button>Schedule an Appointment</button></form>
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
            <td>{{$appointment->doctorUser->doctorDetail->specialization->name}}</td>
            <td>{{$appointment->doctorUser->name}}</td>
            <td>{{$appointment->appointment_date}}</td>
            <td>{{date('h:i A', strtotime($appointment->appointment_time))}}</td>
            <td><a href="{{url('appointment').'/'.$appointment->id.'/edit'}}">Reschedule</a></td>
            <th>
                <form action="{{url('appointment').'/'.$appointment->id}}" method ="POST">
                @csrf
                @method('delete')
                    <input type="submit" value ="Cancel"/>
                </form>
            </th>
        </tr>
        @endforeach
    </table>
@push('js')
@endpush
@endsection
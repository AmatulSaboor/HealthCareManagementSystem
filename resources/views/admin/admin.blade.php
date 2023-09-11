@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container" class ="index">
    <h4>Doctors List</h4>
    <span>{{session()->get('error_message')}}</span>
    <form action="{{url('doctor/create')}}"><button>Add New Doctor</button></form>
    <table>
        <tr>
            <th>Name</th>
            <th>Eductaion</th>
            <th>Specialization</th>
            <th>Designation</th>
            <th>Experience</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Working Days</th>
            <th>Timings</th>
            <th>Charges</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($doctors as $doctor)
        @if($doctor && $doctor->doctorDetail)
        <tr>
            <td>{{$doctor->name}}</td>
            <td>{{$doctor->doctorDetail->education->name}}</td>
            <td>{{$doctor->doctorDetail->specialization->name}}</td>
            <td>{{$doctor->doctorDetail->designation->name}}</td>
            <td>{{$doctor->doctorDetail->experience}}</td>
            <td>@calculateAge($doctor->doctorDetail->dob)</td>
            <td>{{$doctor->doctorDetail->gender}}</td>
            <td>{{$doctor->doctorDetail->working_days}}</td>
            <td>{{$doctor->doctorDetail->start_time. ' to ' .$doctor->doctorDetail->end_time}}</td>
            <td>{{$doctor->doctorDetail->charges}}</td>
            <td><a href="{{url('doctor').'/'.$doctor->id}}">Edit</a></td>
            <th>
                <form action="{{url('doctor').'/'.$doctor->id.'/edit'}}" method ="POST">
                @csrf
                @method('delete')
                    <input type="submit" value ="delete"/>
                </form>
            </th>
        </tr>
        @endif
        @endforeach
    </table>
</div>
@push('js')
@endpush
@endsection
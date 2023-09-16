@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container" class ="index">
    <h4>Doctors List</h4>
    <span>{{session()->get('error_message')}}</span>
    <form action="{{url('doctor/create')}}" class="d-flex justify-content-end"><button>+ Add New Doctor</button></form>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Eductaion</th>
            <th>Specialization</th>
            <th>Designation</th>
            <th>Experience</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Working Days</th>
            <th>Timings</th>
            <th>Conusltaion Fee</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        @foreach($doctors as $doctor)
        <tr>
            <td>{{$doctor->name}}</td>
            <td>{{$doctor->email}}</td>
            @if($doctor && $doctor->doctorDetail)
            <td>{{$doctor->doctorDetail->education->name}}</td>
            <td>{{$doctor->doctorDetail->specialization->name}}</td>
            <td>{{$doctor->doctorDetail->designation->name}}</td>
            <td>{{$doctor->doctorDetail->experience}} year(s)</td>
            <td>@calculateAge($doctor->doctorDetail->dob)</td>
            <td>{{$doctor->doctorDetail->gender}}</td>
            <td>
                @foreach($doctor->doctorWorkingDays as $doctor_day)
                {{$doctor_day->day}}
                @endforeach
            </td>
            <td>{{ date('h:i A', strtotime($doctor->doctorDetail->start_time)). ' to ' .date('h:i A', strtotime($doctor->doctorDetail->end_time))}}</td>
            <td>{{$doctor->doctorDetail->conusltaion_fee}}</td>
            @endif
            <td><button class="activate"><a href="" class="activate">Activate</a></button></td>
            <td><button class="edit"><a href="{{url('doctor').'/'.$doctor->id.'/edit'}}" class="edit">Edit</a></button></td>
            <th>
                <form action="{{url('doctor').'/'.$doctor->id}}" method ="POST">
                @csrf
                @method('delete')
                    <!-- <input type="submit" value ="delete" /> -->
                    <button type="submit" value="delete" class="delete"><a href="" class="delete">Delete</a></button>
                </form>
            </th>
        </tr>
        @endforeach
    </table>
    {{$doctors->links()}}
</div>
{{-- @if(session('success_message'))
    @sweetAlert(session('success_message'))
@endif --}}
@push('js')
@endpush
@endsection
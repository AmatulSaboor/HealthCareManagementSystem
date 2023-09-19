@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container">

    <!-- Error Message -->
    @if(session()->get('error_message'))
    <div class="alert alert-danger">{{session()->get('error_message')}}</div>
    @endif

    <!-- Appointments Table -->
    <form action="{{url('appointment/create')}}" class="d-flex justify-content-between">
        <h4 class="d-flex align-items-end mb-0">Appointments List (recent first)</h4>
        <button class="schedule-btn mb-2">+ Schedule an Appointment</button>
    </form>
    <div>
        @if($appointments->isEmpty())
        <label class="null-check">You don't have any scheduled appointments</label>
        @else
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
                <td><a href="{{url('appointment').'/'.$appointment->id.'/edit'}}"
                            class="reschedule"><button class="reschedule">Reschedule </button></a></td>
                <th>
                    <form id="delete_form_{{$appointment->id}}" action="{{url('appointment').'/'.$appointment->id}}"
                        method="POST">
                        @csrf
                        @method('delete')
                        <button type="button" class="cancel-app"
                            onclick="confirmationPopUp({{ $appointment->id }}, 'delete_form_', 'appointment')">Cancel
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        @endif
    </div>    
    {{$appointments->links()}}   
</div>

@push('js')
<script>
$(document).ready(function() {
    sucessPopUp("{{ session('sent_email_msg') }}");
});
</script>
@endpush
@endsection
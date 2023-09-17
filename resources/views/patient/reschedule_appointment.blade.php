@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<h4>Reschedule Appointment</h4>
    <span>{{session()->get('error_message')}}</span>
    <form action="{{url('appointment'.'/'.$appointment->id)}}" method="POST" class="form-container">
        @csrf
        @method('put')
        <label>Select Field</label>
        <select id="field_id" name="field_id" data-doctorUrl="{{url('get_doctors_by_field')}}">
            <option value="" hidden>choose field</option>
            @foreach($fields as $field)
            <option value="{{$field->id}}" {{ old('field_id', $appointment->doctorUser->doctorDetail->specialization->id) == $field->id ? 'selected' : '' }} >{{$field->name}}</option>
            @endforeach
        </select>
        @error('field_id')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label>Choose Doctor</label>
        <select id="doctor_dropdown" name="doctor_id" data-timeUrl="{{url('get_time_intervals_by_doctor_id')}}" data-dayUrl="{{url('get_working_days_by_doctor_id')}}">
            <option value="" disabled selected>choose field first</option>
        </select>
        @error('doctor_id')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="appointment_date">Appointment Date</label><span id="doctor_days"></span>
        <input id="appointment_date" type="date" name ="appointment_date" value="{{old('appointment_date', $appointment->appointment_date)}}" min="{{date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))))}}"  max="{{date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d'))))}}" />
        @error('appointment_date')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="appointment_time_dropdwon">Appointment Time</label>
        <select id="appointment_time_dropdwon" name="appointment_time">
            <option value="" disabled selected>choose doctor first</option>
        </select>
        @error('appointment_time')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <input type ="submit" value ="Reschedule" name ="submit"/>
    </form>
    <a href="{{url('appointment')}}">Cancel</a>
@push('js')
<script src="{{ asset('js/ajax_call.js') }}"></script>
{{-- <script src="{{ asset('js/appointment.js') }}"></script> --}}
<script>
    let working_days = [];
    $(document).ready(function () {
        let doctorUrl = $("#field_id").data('doctorurl');
        let dayUrl = $("#doctor_dropdown").data('dayurl');
        let timeUrl = $("#doctor_dropdown").data('timeurl');
        // console.log(doctorUrl + ' | ' + dayUrl + ' | ' + timeUrl);

        if($("#field_id").val()){
            loadDoctors($("#field_id").val(), doctorUrl, timeUrl, dayUrl)
        }
        $("#field_id").on('change',function () {
            let params = $(this).val(); 
            loadDoctors(params, doctorUrl, timeUrl, dayUrl);
        })
        $('#doctor_dropdown').on('change', function () {
            let selected_doctor_id = $(this).val();
            getDoctorDetails(selected_doctor_id, timeUrl, dayUrl)
        });
        $("#appointment_date").on('input', function () {
            let selected_date = new Date($(this).val());
            if(selected_date.getDay() == 0){
                alert("Doctor not working on sundays");
                    this.value = "";
            }
            else if (working_days.length > 0 && !working_days.includes(selected_date.getDay())) {
                    alert("Doctor not working on this day of the week");
                    this.value = "";
                }
            }
        );
        ajaxGet(dayUrl + "/" +"{{old('doctor_id', $appointment->doctor_id)}}",{},(status,data)=>{
            if (status){
                working_days = data;
                $("#doctor_days").empty();  
                $("#doctor_days").append("Doctor working days are "+ working_days.join(', '));
            }else{console.log("day error:",data);}
            }
        )
    });

    // --------- FUNCTION : load doctor drop down on field selection --------------
    function loadDoctors(params, doctorUrl, timeUrl, dayUrl) {
        ajaxGet(doctorUrl + '/' +params,{},(status,data)=>{
            if (status){
                $("#doctor_dropdown").empty();
                if (data.length > 0){
                    for(let item of data){
                        let old_value = "{{old('doctor_id', $appointment->doctor_id)}}"
                        let selected = (item.user_id == old_value) ? 'selected' : '';
                        $("#doctor_dropdown").append("<option value='"+item.user_id+"' " + selected + ">"+item.user.name+"</option>");
                    }
                }else{
                    $("#doctor_dropdown").append("<option value=''>no doctor available</option>");
                    $("#doctor_days").empty();
                    $("#appointment_time_dropdwon").empty();
                    $("#appointment_time_dropdwon").append("<option value=''>choose doctor first</option>");
                }
                if(data.length > 0){
                    getDoctorDetails(data[0].user_id, timeUrl, dayUrl)}
            }else{console.log("error:",data);}
        })
    }

    // --------- FUNCTION : get doctor details on doctor selection (timings and working hours) -------------
    function getDoctorDetails(doctor_id, timeUrl, dayUrl){
        $("#appointment_date").val("");  
        let selected_date = $("#appointment_date").val();
        console.log(selected_date);
        ajaxGet(timeUrl + "/" +doctor_id,{},(status,data)=>{
                if (status){
                    $("#appointment_time_dropdwon").empty();
                    for(let item of data){
                        let old_value = "{{old('appointment_time', $appointment->appointment_time)}}"
                        let selected = (item == old_value) ? 'selected' : '';
                        $("#appointment_time_dropdwon").append("<option value='"+item+"' " + selected + ">"+item+"</option>");
                    }
                }else{console.log("time error:",data);}
            }
        )
        ajaxGet(dayUrl + "/" +doctor_id,{},(status,data)=>{
            if (status){
                working_days = data;
                $("#doctor_days").empty();  
                $("#doctor_days").append("Doctor working days are "+ working_days.join(', '));
            }else{console.log("day error:",data);}
            }
        )
    }
</script> 
@endpush
@endsection
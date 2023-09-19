@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ url('css/login.css') }}"> 
@endpush
@section('content')
<div class="container">

    <!-- Error Message -->
    @if(session()->get('error_message'))
    <div class="alert alert-danger">{{session()->get('error_message')}}</div>
    @endif

    <!-- Reschedule Appointment Form -->
    <h4 class="font-weight-bold text-center mb-3">Reschedule Appointment</h4>
    <form action="{{ url('appointment'.'/'.$appointment->id) }}" method="POST" class="form-container">
        @csrf
        @method('put')

        <!-- Choose Field -->
        <div class="form-group">
            <label for="field_id">Select Field <span class="text-danger">*</span></label>
            <select id="field_id" name="field_id" data-doctorUrl="{{ url('get_doctors_by_field') }}" class="form-control custom-select">
                <option value="" hidden>Choose field</option>
                @foreach($fields as $field)
                    <option value="{{ $field->id }}" {{ old('field_id', $appointment->doctorUser->doctorDetail->specialization->id) == $field->id ? 'selected' : '' }}>{{ $field->name }}</option>
                @endforeach
            </select>
            @error('field_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Choose Doctor -->
        <div class="form-group">
            <label for="doctor_dropdown">Choose Doctor <span class="text-danger">*</span></label>
            <select id="doctor_dropdown" name="doctor_id" data-timeUrl="{{ url('get_time_intervals_by_doctor_id') }}" data-dayUrl="{{ url('get_working_days_by_doctor_id') }}" class="form-control custom-select" >
                <option value="" disabled selected>Choose field first</option>
            </select>
            @error('doctor_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Choose Date -->
        <div class="form-group">
            <label for="appointment_date">Appointment Date <span class="text-danger">*</span></label><span id="doctor_days"></span>
            <input id="appointment_date" type="date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" class="form-control" min="{{ date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d')))) }}"  max="{{ date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d')))) }}" />
            @error('appointment_date')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Choose Time -->
        <div class="form-group">
            <label for="appointment_time_dropdwon">Appointment Time <span class="text-danger">*</span></label>
            <select id="appointment_time_dropdwon" name="appointment_time" class="form-control custom-select" >
                <option value="" disabled selected>Choose doctor first</option>
            </select>
            @error('appointment_time')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit -->
        <div class="text-center">
            <input type="submit" value="Reschedule" name="submit" class="btn btn-primary login-btn" />
        </div>
    </form>
    <button class="btn btn-primary mt-3 ml-3 cancel-btn"><a href="{{url('appointment')}}" class="cancel-btn">Cancel</a></button>
</div>
@push('js')
<script src="{{ asset('js/ajax_call.js') }}"></script>
<script>
    let working_days = [];
    const daysOfWeek = {
    0 : "Sunday",
    1 : "Monday",
    2 : "Tuesday",
    3 : "Wednesday",
    4 : "Thursday",
    5 : "Friday",
    6 : "Saturday"
    };
    $(document).ready(function () {
        let doctorUrl = $("#field_id").data('doctorurl');
        let dayUrl = $("#doctor_dropdown").data('dayurl');
        let timeUrl = $("#doctor_dropdown").data('timeurl');

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
                infoPopUp("Doctor not working on Sundays");
                    this.value = "";
            }
            else if (working_days.length > 0 && !working_days.includes(daysOfWeek[selected_date.getDay()])) {
                    infoPopUp("Doctor not working on this day of the week");
                    this.value = "";
                }
            }
        );
        ajaxGet(dayUrl + "/" +"{{old('doctor_id', $appointment->doctor_id)}}",{},(status,data)=>{
            if (status){
                working_days = data;
                $("#doctor_days").empty();  
                $("#doctor_days").append("Doctor working days are "+ working_days.join(', '));
            }else{console.log("day error:","some error while getting day");}
            }
        )
        infoPopUp("{{ session('edit_appointment_err_msg') }}");
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
            }else{console.log("doctor error:","some error while getting doctors");}
        })
    }

    // --------- FUNCTION : get doctor details on doctor selection (timings and working days) -------------
    function getDoctorDetails(doctor_id, timeUrl, dayUrl){
        ajaxGet(timeUrl + "/" +doctor_id,{},(status,data)=>{
                if (status){
                    $("#appointment_time_dropdwon").empty();
                    for(let item of data){
                        let old_value = "{{old('appointment_time', $appointment->appointment_time)}}"
                        let selected = (item == old_value) ? 'selected' : '';
                        $("#appointment_time_dropdwon").append("<option value='"+item+"' " + selected + ">"+item+"</option>");
                    }
                }else{console.log("time error:","some error while getting time");}
            }
        )
        ajaxGet(dayUrl + "/" +doctor_id,{},(status,data)=>{
            if (status){
                working_days = data;
                $("#doctor_days").empty();  
                $("#doctor_days").append("Doctor working days are "+ working_days.join(', '));
            }else{console.log("day error:","some error while getting day");}
            }
        )
    }
</script> 
@endpush
@endsection
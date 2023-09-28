@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
<link href="{{ asset('css/login.css') }}" rel="stylesheet"> 
@endpush
@section('content')
<div class="container">

    <!-- Error Message -->
    @if(session()->get('error_message'))
    <div class="text-danger mt-2">{{session()->get('error_message')}}</div>
    @endif

    <!-- Schedule Appointment Form -->
    <h4 class="font-weight-bold text-center mb-3">Schedule Appointment</h4>
    <div class="d-flex justify-content-center">
        <form action="{{ url('appointment') }}" method="POST" class="form-container col-md-6">
            @csrf

            <!-- Choose Field -->
            <div class="form-group">
                <label for="field_id">Select Field <span class="text-danger">*</span></label>
                <select id="field_id" name="field_id" data-doctorUrl="{{ url('get_doctors_by_field') }}" class="form-control custom-select">
                    <option value="" hidden>Choose field</option>
                    @foreach($fields as $field)
                        <option value="{{ $field->id }}" {{ old('field_id') == $field->id ? 'selected' : '' }}>{{ $field->name }}</option>
                    @endforeach
                </select>
                @error('field_id')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Choose Doctor -->
            <div class="form-group">
                <label for="doctor_dropdown">Choose Doctor  <span class="text-danger">*</span></label>
                <select id="doctor_dropdown" name="doctor_id" data-timeUrl="{{ url('get_time_intervals_by_doctor_id') }}" data-dayUrl="{{ url('get_working_days_by_doctor_id') }}" class="form-control custom-select">
                    <option value="" disabled selected>Choose field first</option>
                </select>
                @error('doctor_id')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Choose Date -->
            <div class="form-group">
                <label for="appointment_date">Appointment Date  <span class="text-danger">*</span></label>
                <span id="doctor_days"></span>
                <input id="appointment_date" readonly type="date" name="appointment_date" value="{{ old('appointment_date') }}" min="{{ date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d')))) }}" max="{{ date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d')))) }}" class="form-control "/>
                @error('appointment_date')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Choose Time -->
            <div class="form-group">
                <label for="appointment_time_dropdwon">Appointment Time  <span class="text-danger">*</span></label>
                <select id="appointment_time_dropdwon" name="appointment_time" class="form-control custom-select">
                    <option value="" disabled selected>Choose doctor first</option>
                </select>
                @error('appointment_time')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit -->
            <div class="text-center">
                <input type="submit" class="btn btn-primary login-btn" value="Schedule" name="submit" />
            </div>
        </form>
    </div>
    
       <a href="{{url('appointment')}}" class="cancel-btn"> <button class="btn btn-primary mt-3  cancel-btn">Cancel </button></a>
   
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
            getDoctorDetails(selected_doctor_id, timeUrl, dayUrl);
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
    });

    // --------- FUNCTION : load doctor drop down on field selection --------------
    function loadDoctors(params, doctorUrl, timeUrl, dayUrl) {
        $("#appointment_date").val("");
        ajaxGet(doctorUrl + '/' +params,{},(status,data)=>{
            if (status){
                $("#doctor_dropdown").empty();
                if (data.length > 0){
                    for(let item of data){
                        let old_value = "{{old('doctor_id')}}"
                        let selected = (item.user_id == old_value) ? 'selected' : '';
                        $("#doctor_dropdown").append("<option value='"+item.user_id+"' " + selected + ">"+item.user.name+"</option>");
                    }
                }else{
                    $("#doctor_dropdown").append("<option value=''>no doctor available</option>");
                    $("#appointment_time_dropdwon").empty();
                    $("#appointment_time_dropdwon").append("<option value=''>choose doctor first</option>");
                }
                if(data.length > 0){
                    getDoctorDetails(data[0].user_id, timeUrl, dayUrl)}
            }else{console.log("doctor error:","some error while getting doctor");}
        })
        infoPopUp("{{ session('add_appointment_err_msg') }}");
    }

    // --------- FUNCTION : get doctor details on doctor selection (timings and working days) -------------
    function getDoctorDetails(doctor_id, timeUrl, dayUrl){
        ajaxGet(timeUrl + "/" +doctor_id,{},(status,data)=>{
                if (status){
                    $("#appointment_time_dropdwon").empty();
                    for(let item of data){
                        let selected = (item == "{{old('appointment_time')}}") ? 'selected' : '';
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
        $("#appointment_date").attr('readonly',false);
    }
</script>
@endpush
@endsection
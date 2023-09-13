@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<h4>Book Appointment</h4>
    <span>{{session()->get('error_message')}}</span>
    <form action="{{url('appointment')}}" method="POST" class="form-container">
        @csrf
        <label>Select Field</label>
        <select id="field_id" name="field_id">
            <option value="" disabled selected hidden>choose field</option>
            @foreach($fields as $field)
            <option value="{{$field->id}}" {{old('field_id')}}>{{$field->name}}</option>
            @endforeach
        </select>
        @error('field_id')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label>Choose Doctor</label>
        <select id="doctor_dropdown" name="doctor_id">
            <option value="" disabled selected hidden>choose doctor</option>
        </select>
        @error('doctor_id')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="appointment_date">Appointment Date</label>
        <input id="appointment_date" type="date" name ="appointment_date" value="{{old('appointment_date')}}" min="{{date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))))}}"  max="{{date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d'))))}}" />
        @error('appointment_date')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="appointment_time_dropdwon">Appointment Time</label>
        <select id="appointment_time_dropdwon" name="appointment_time">
            <option value="" disabled selected hidden>choose time</option>
        </select>
        @error('appointment_time')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <input type ="submit" value ="Schedule" name ="submit"/>
    </form>
@push('js')
<script>
    let working_days = [];
    $(document).ready(function () {
        $('#doctor_dropdown').on('change', function () {
            var selected_value = $(this).val();
            getDoctorDetails(selected_value)
            ajaxGet("{{url('get_working_days_by_doctor_id')}}/"+selected_value,{},(status,data)=>{
                if (status){
                    working_days = data;
                    console.log("success:",data);
                    // $("#appointment_time_dropdwon").empty();
                    // for(let item of data){
                    //     $("#appointment_time_dropdwon").append("<option value='"+item+"'>"+item+"</option>");
                    // }
                }else{
                    console.log("error:",data);
                }
            })
        });
    });
    $(document).ready(function () {
        $("#appointment_date").on('input', function () {
            var selected_date = new Date($(this).val());
            console.log(working_days)
            if (working_days.includes(selected_date.getDay())) {
                    alert("Sundays are not allowed. Please choose a different date.");
                    this.value = "";
                }
        });
    });
    $(document).ready(function () {
        $("#field_id").on('change',function () {
            let params = $(this).val();
            ajaxGet("{{url('get_doctors_by_field')}}/"+params,{},(status,data)=>{
                if (status){
                    console.log("success:",data);
                    $("#doctor_dropdown").empty();
                    for(let item of data){
                        $("#doctor_dropdown").append("<option value='"+item.user_id+"'>"+item.user.name+"</option>");
                    }
                    if(data.length > 0){
                        getDoctorDetails(data[0].user_id)
                    }
                }else{
                    console.log("error:",data);
                }
            })
        })
    });
    function getDoctorDetails(doctor_id){
        ajaxGet("{{url('get_time_intervals_by_doctor_id')}}/"+doctor_id,{},(status,data)=>{
                if (status){
                    $("#appointment_time_dropdwon").empty();
                    for(let item of data){
                        $("#appointment_time_dropdwon").append("<option value='"+item+"'>"+item+"</option>");
                    }
                }else{
                    console.log("error:",data);
                }
            })
    }
</script>
@endpush
@endsection
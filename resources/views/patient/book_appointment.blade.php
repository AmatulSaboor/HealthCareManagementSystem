@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<h4>Book Appointment</h4>
    <span>{{session()->get('error_message')}}</span>
    <form action="{{url('store_appointment')}}" method="POST" class="form-container">
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
        <select id="doctor_dropdown" name="dcotor_id">
            <option value="" disabled selected hidden>choose doctor</option>
            {{-- @if($doctors)
            @foreach($doctors as $doctor)
            <option value="{{$doctor->id}}" {{old('doctor_id')}}>{{$doctor->name}}</option>
            @endforeach
            @endif --}}
        </select>
        @error('doctor_id')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="appointment_date">Appointment Date</label>
        <input id="appointment_date" type="date" name ="appointment_date" value="{{old('appointment_date')}}" min="{{date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))))}}"  max="{{date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d'))))}}" />
        @error('appointment_date')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="appointment_time">Appointment Time</label>
        <input id="appointment_time" type="time" name ="appointment_time" value="{{old('appointment_time')}}"/>
        @error('appointment_time')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <input type ="submit" value ="Book" name ="submit"/>
    </form>
@push('js')
<script>
       $(document).ready(function () {
            $("#field_id").on('change',function () {
                let params = $(this).val()
                ajaxGet("{{url('get_doctors_by_field')}}/"+params,{},(status,data)=>{
                  if (status){
                      console.log("success:",data);
                      $("#doctor_dropdown").empty();
                        for(let item of data){
                            $("#doctor_dropdown").append("<option value='"+item.id+"'>"+item.first_name+"</option>");
                        }
                  }else{
                      console.log("error:",data);
                  }
                })
            })
        });
</script>
@endpush
@endsection
@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container" class ="index">
    <h4>Create Doctor</h4>
    <span>{{session()->get('error_message')}}</span>
    <form action="{{url('doctor')}}" method="POST" class="form-container">
        @csrf
        <label for="first_name">First Name</label>
        <input id="first_name" type="text" name ="first_name" value="{{old('first_name')}}"/>
        @error('first_name')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="last_name">Last Name</label>
        <input id="last_name" type="text" name ="last_name" value="{{old('last_name')}}"/>
        @error('last_name')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="email">Email</label>
        <input id="email" type="text" name ="email" value="{{old('email')}}"/>
        @error('email')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="password">Password</label>
        <input id="password" type="password" name ="password" value="{{old('password')}}"/>
        @error('password')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label>Education</label>
        <select name="education_id">
            <option value="" disabled selected hidden>choose education</option>
            @foreach($educations as $education)
            <option value="{{$education->id}}" {{old('education_id')}}>{{$education->name}}</option>
            @endforeach
        </select>
        @error('education_id')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label>Specialization</label>
        <select name="specialization_id">
            <option value="" disabled selected hidden>choose specialization</option>
            @foreach($specializations as $specialization)
            <option value="{{$specialization->id}}" {{old('specialization_id')}}>{{$specialization->name}}</option>
            @endforeach
        </select>
        @error('specialization_id')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label>Designation</label>
        <select name="designation_id">
            <option value="" disabled selected hidden>choose designation</option>
            @foreach($designations as $designation)
            <option value="{{$designation->id}}" {{old('designation_id')}}>{{$designation->name}}</option>
            @endforeach
        </select>
        @error('designation_id')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="experience">Experience</label>
        <input id="experience" type="text" name ="experience" value="{{old('experience')}}"/>
        @error('experience')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="dob">Date of Birth</label>
        <input id="dob" type="date" name ="dob" value="{{old('dob')}}" min="{{date('Y-m-d', strtotime("-80 years", strtotime(date('Y-m-d'))))}}"  max="{{date('Y-m-d', strtotime("-20 years", strtotime(date('Y-m-d'))))}}" />
        @error('dob')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label>Gender</label>
        <input type="radio" id="male" name="gender" value="male"/>
        <label for="male">male</label>
        <input type="radio" id="female" name="gender" value="female"/>
        <label for="female">female</label>
        <label for="working_days">Working Days</label>
        <input type="checkbox" value="Monday" name="working_days[]"/><label>Monday</label>
        <input type="checkbox" value="Tuesday" name="working_days[]"/><label>Tuesday</label>
        <input type="checkbox" value="Wednesday" name="working_days[]"/><label>Wednesday</label>
        <input type="checkbox" value="Thursday" name="working_days[]"/><label>Thursday</label>
        <input type="checkbox" value="Friday" name="working_days[]"/><label>Friday</label>
        {{-- <input id="working_days" type="text" name ="working_days" value="{{old('working_days')}}"/>
        @error('working_days')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror --}}
        <label for="start_time">Start Time</label>
        <input id="start_time" type="time" name ="start_time" value="{{old('start_time')}}"/>
        @error('start_time')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="end_time">End Time</label>
        <input id="end_time" type="time" name ="end_time" value="{{old('end_time')}}"/>
        @error('end_time')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="charges">Charges</label>
        <input id="charges" type="text" name ="charges" value="{{old('charges')}}"/>
        @error('charges')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <input type ="submit" value = "Add" name ="submit"/>
    </form>
</div>
@push('js')
@endpush
@endsection
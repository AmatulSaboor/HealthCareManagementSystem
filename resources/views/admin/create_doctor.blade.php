@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container" class ="index">
    <h4>Create Doctor</h4>
    {{-- TODO: error span message --}}
    <span>{{session()->get('error_message')}}</span>
    <form action="{{url('doctor')}}" method="POST" class="form-container">
        @csrf
        <div class="container mt-4">
            <div class="row">
                <div class="col">
                    <ul class="nav nav-tabs" id="stepper-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="step1-tab" data-toggle="tab" href="#step1">Step 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2">Step 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="step3-tab" data-toggle="tab" href="#step3">Step 3</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="stepper-content">
                        <div class="tab-pane fade show active" id="step1">
                            <h3>Registeration Info</h3>
                            <label for="first_name">First Name</label>
                            <input id="first_name" type="text" name ="first_name" value="{{old('first_name')}}" placeholder="enter first name"/>
                            @error('first_name')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <label for="last_name">Last Name</label>
                            <input id="last_name" type="text" name ="last_name" value="{{old('last_name')}}"  placeholder="enter last name"/>
                            @error('last_name')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <label for="email">Email</label>
                            <input id="email" type="text" name ="email" value="{{old('email')}}"  placeholder="enter email"/>
                            @error('email')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <label for="password">Password</label>
                            <input id="password" type="password" name ="password" value="{{old('password')}}"  placeholder="enter password"/>
                            @error('password')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <label for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" type="password" name ="password_confirmation" value="{{old('password_confirmation ')}}"  placeholder="re-enter password"/>
                            @error('password_confirmation')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="tab-pane fade" id="step2">
                            <h3>Professional Info</h3>
                            <label>Specialization</label>
                            <select name="specialization_id">
                                @foreach($specializations as $specialization)
                                <option value="{{$specialization->id}}" {{old('specialization_id') == $specialization->id ? 'selected' : ''}}>{{$specialization->name}}</option>
                                @endforeach
                            </select>
                            @error('specialization_id')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <label>Designation</label>
                            <select name="designation_id">
                                @foreach($designations as $designation)
                                <option value="{{$designation->id}}" {{old('designation_id') == $designation->id ? 'selected' : ''}}>{{$designation->name}}</option>
                                @endforeach
                            </select>
                            @error('designation_id')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <div class="checkbox-container">
                                <label for="working_days">Working Days</label>
                                <input type="checkbox" value=1 name="working_days[]" {{in_array(1, old('working_days', [])) ? 'checked' : ''}}/><label>Mon</label>
                                <input type="checkbox" value=2 name="working_days[]" {{in_array(2, old('working_days', [])) ?  'checked' : ''}}/><label>Tue</label>
                                <input type="checkbox" value=3 name="working_days[]" {{in_array(3, old('working_days', [])) ?  'checked' : ''}}/><label>Wed</label>
                                <input type="checkbox" value=4 name="working_days[]" {{in_array(4, old('working_days', [])) ?  'checked' : ''}}/><label>Thur</label>
                                <input type="checkbox" value=5 name="working_days[]" {{in_array(5, old('working_days', [])) ? 'checked' : ''}}/><label>Fri</label>
                            </div>
                            @error('working_days')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <label for="start_time">Start Time</label>
                            <select name="start_time">
                                @foreach($start_times as $start_time)
                                <option value="{{$start_time}}" {{old('start_time') == $start_time ? 'selected' : ''}}>{{$start_time}}</option>
                                @endforeach
                            </select>
                            @error('start_time')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <label for="end_time">End Time</label>
                            <select name="end_time">
                                @foreach($end_times as $end_time)
                                <option value="{{$end_time}}" {{old('end_time') == $end_time ? 'selected' : ''}}>{{$end_time}}</option>
                                @endforeach
                            </select>      
                            @error('end_time')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <label for="conusltaion_fee">Conusltaion Fee</label>
                            <input id="conusltaion_fee" type="text" name ="conusltaion_fee" value="{{old('conusltaion_fee')}}"  placeholder="fee should be between Rs.500 and Rs.5000"/>
                            @error('conusltaion_fee')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="tab-pane fade" id="step3">
                            <h3>Personal Info</h3>
                            <label>Education</label>
                            <select name="education_id">
                                @foreach($educations as $education)
                                <option value="{{$education->id}}" {{old('education_id') ==$education->id ? 'selected' : ''}}>{{$education->name}}</option>
                                @endforeach
                            </select>
                            @error('education_id')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <label for="experience">Experience</label>
                            <input id="experience" type="text" name ="experience" value="{{old('experience')}}"  placeholder="experience in years"/>
                            @error('experience')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <label for="dob">Date of Birth</label>
                            <input id="dob" type="date" name ="dob" value="{{old('dob')}}" min="{{date('Y-m-d', strtotime("-80 years", strtotime(date('Y-m-d'))))}}"  max="{{date('Y-m-d', strtotime("-20 years", strtotime(date('Y-m-d'))))}}" />
                            @error('dob')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <div class="radiobutton-container">
                                <label>Gender</label>
                                <input type="radio" id="male" name="gender" value="Male" {{old('gender') == 'Male' ? 'checked' : ''}}/>
                                <label for="male">male</label>
                                <input type="radio" id="female" name="gender" value="Female" {{old('gender') == 'Female' ? 'checked' : ''}}/>
                                <label for="female">female</label>
                            </div>
                            <input type ="submit" value = "Add" name ="submit"/>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </form>
    <a href="{{url('doctor')}}">Cancel</a>
</div>
@push('js')
<script>
    $(document).ready(function () {
        $('#stepper-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        });
    });
</script>
@endpush
@endsection


@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ url('css/login.css') }}"> 

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
                <div class="col-md-7">
                    <ul class="nav nav-tabs" id="stepper-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="step1-tab" data-toggle="tab" href="#step1" class="step">Step 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2" class="step">Step 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="step3-tab" data-toggle="tab" href="#step3" class="step">Step 3</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="stepper-content">
                        <div class="tab-pane fade show active" id="step1">
                            <h3 class="my-2 text-center">Account Info</h3>

                            <div class="form-group">
                                <label for="first_name">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Enter first name" />
                                @error('first_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Enter last name" />
                                @error('last_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email" />
                                @error('email')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="Enter password" />
                                @error('password')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Re-enter password" />
                                @error('password_confirmation')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                       <div class="tab-pane fade" id="step2">
                        <h3>Professional Info</h3>

                            <!-- Specialization -->
                            <div class="form-group">
                                <label for="specialization_id">Specialization <span class="text-danger">*</span></label>
                                <select class="form-control" id="specialization_id" name="specialization_id">
                                    @foreach($specializations as $specialization)
                                        <option value="{{ $specialization->id }}" {{ old('specialization_id') == $specialization->id ? 'selected' : '' }}>
                                            {{ $specialization->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('specialization_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Designation -->
                            <div class="form-group">
                                <label for="designation_id">Designation <span class="text-danger">*</span></label>
                                <select class="form-control" id="designation_id" name="designation_id">
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                            {{ $designation->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('designation_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Working Days -->
                            <div class="form-group">
                                <label>Working Days <span class="text-danger">*</span></label>
                                <div class="checkbox-container">
                                    <div class="form-check d-block">
                                        <input class="form-check-input" type="checkbox" id="working_day_1" name="working_days[]" value="1"{{ in_array(1, old('working_days', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label mx-1" for="working_day_1" >Mon</label>
                                            <input class="form-check-input" type="checkbox" id="working_day_2" name="working_days[]" value="2"{{ in_array(2, old('working_days', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label mx-1" for="working_day_1" class="mx-1">Tues</label>
                                            <input class="form-check-input" type="checkbox" id="working_day_3" name="working_days[]" value="3"{{ in_array(3, old('working_days', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label mx-1" for="working_day_1" class="mx-1">Wed</label>
                                            <input class="form-check-input " type="checkbox" id="working_day_4" name="working_days[]" value="4"{{ in_array(4, old('working_days', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label mx-1" for="working_day_1" class="mx-1">Thursday</label>
                                            <input class="form-check-input" type="checkbox" id="working_day_5" name="working_days[]" value="5"{{ in_array(5, old('working_days', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label mx-1" for="working_day_1" class="mx-1">Fri</label>
                                    </div>
                                    <!-- Repeat the above block for other days -->
                                </div>
                                @error('working_days')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Start Time -->
                            <div class="form-group">
                                <label for="start_time">Start Time <span class="text-danger">*</span></label>
                                <select class="form-control" id="start_time" name="start_time">
                                    @foreach($start_times as $start_time)
                                        <option value="{{ $start_time }}" {{ old('start_time') == $start_time ? 'selected' : '' }}>
                                            {{ $start_time }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('start_time')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- End Time -->
                            <div class="form-group">
                                <label for="end_time">End Time <span class="text-danger">*</span></label>
                                <select class="form-control" id="end_time" name="end_time">
                                    @foreach($end_times as $end_time)
                                        <option value="{{ $end_time }}" {{ old('end_time') == $end_time ? 'selected' : '' }}>
                                            {{ $end_time }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('end_time')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Consultation Fee -->
                            <div class="form-group">
                                <label for="conusltaion_fee">Consultation Fee <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="conusltaion_fee" name="conusltaion_fee"
                                    value="{{ old('conusltaion_fee') }}" placeholder="Fee should be between Rs.500 and Rs.5000" />
                                @error('conusltaion_fee')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="tab-pane fade" id="step3">
                            <h3>Personal Info</h3>

                            <!-- Education -->
                            <div class="form-group">
                                <label for="education_id">Education <span class="text-danger">*</span></label>
                                <select class="form-control" id="education_id" name="education_id">
                                    @foreach($educations as $education)
                                        <option value="{{ $education->id }}" {{ old('education_id') == $education->id ? 'selected' : '' }}>
                                            {{ $education->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('education_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Experience -->
                            <div class="form-group">
                                <label for="experience">Experience <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="experience" name="experience"
                                    value="{{ old('experience') }}" placeholder="Experience in years" />
                                @error('experience')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div class="form-group">
                                <label for="dob">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="dob" name="dob"
                                    value="{{ old('dob') }}" min="{{ date('Y-m-d', strtotime("-80 years")) }}" max="{{ date('Y-m-d', strtotime("-20 years")) }}" />
                                @error('dob')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="form-group">
                                <label>Gender <span class="text-danger">*</span></label>
                                <div class="radiobutton-container">
                                    <div class="form-check form-check">
                                        <input class="form-check-input" type="radio" id="male" name="gender" value="Male"
                                            {{ old('gender') == 'Male' ? 'checked' : '' }}>
                                        <label class="form-check-label ms-2" for="male">Male</label>
                                    </div>
                                    <div class="form-check form-check">
                                        <input class="form-check-input" type="radio" id="female" name="gender" value="Female"
                                            {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                        <label class="form-check-label ms-2" for="female">Female</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <input type="submit" class="btn btn-primary login-btn" value="Add" name="submit" />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-center align-items-center">
                    <img src="{{'/images/add-doctor.png'}}" style="height:400px">
                </div>
            </div> 
        </div>
    </form>
    <div>
        <button class="btn btn-primary mt-3 prev-btn" id="prevBtn" onclick="prevStep()">Previous</button>
        <button class="btn btn-primary mt-3 ml-3 next-btn" id="nextBtn" onclick="nextStep()">Next</button>
        <button class="btn btn-primary mt-3 ml-3 cancel-btn"><a href="{{url('doctor')}}" class="cancel-btn">Cancel</a></button>
    </div>
</div>
@push('js')
<script src="{{asset('js/stepper.js')}}"></script>
@endpush
@endsection


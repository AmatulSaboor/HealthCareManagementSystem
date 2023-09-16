@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container" class ="index">
    <h4>Update Doctor</h4>
    {{-- TODO: error span message --}}
    <span>{{session()->get('error_message')}}</span>
    <form action="{{url('doctor'.'/'.$doctor->id)}}" method="POST" class="form-container">
        @csrf
        @method('put')
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
                        <h3 class="my-2 text-center">Registration Info</h3>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $doctor->first_name) }}" placeholder="Enter first name" />
                            @error('first_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $doctor->last_name) }}" placeholder="Enter last name" />
                            @error('last_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="tab-pane fade" id="step2">
                            <h3 class="my-2 text-center">Professional Info</h3>
                            <div class="form-group">
                                <label for="specialization">Specialization</label>
                                <select class="form-control" id="specialization" name="specialization_id">
                                    @foreach($specializations as $specialization)
                                    <option value="{{ $specialization->id }}" {{ old('specialization_id', $doctor->doctorDetail->specialization_id) == $specialization->id ? 'selected' : '' }}>
                                        {{ $specialization->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('specialization_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="designation">Designation</label>
                                <select class="form-control" id="designation" name="designation_id">
                                    @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}" {{ old('designation_id', $doctor->doctorDetail->designation_id) == $designation->id ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('designation_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group checkbox-container">
                                <label>Working Days</label>
                                <div class="form-check">
                                    <input class="form-check-input ms-2" type="checkbox" id="working_day_mon" value="1" name="working_days[]" {{ in_array(1, old('working_days', $doctor->doctorWorkingDays->pluck('day')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label mx-1" for="working_day_mon">Mon</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="working_day_tue" value="2" name="working_days[]" {{ in_array(2, old('working_days', $doctor->doctorWorkingDays->pluck('day')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label mx-1" for="working_day_tue">Tue</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="working_day_wed" value="3" name="working_days[]" {{ in_array(3, old('working_days', $doctor->doctorWorkingDays->pluck('day')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label mx-1" for="working_day_wed">Wed</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="working_day_thu" value="4" name="working_days[]" {{ in_array(4, old('working_days', $doctor->doctorWorkingDays->pluck('day')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label mx-1" for="working_day_thu">Thur</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="working_day_fri" value="5" name="working_days[]" {{ in_array(5, old('working_days', $doctor->doctorWorkingDays->pluck('day')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label mx-1" for="working_day_fri">Fri</label>
                                </div>
                            </div>
                            @error('working_days')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label for="start_time">Start Time</label>
                                <select class="form-control" id="start_time" name="start_time">
                                    @foreach($start_times as $start_time)
                                    <option value="{{ $start_time }}" {{ old('start_time', date('h:i A', strtotime($doctor->doctorDetail->start_time))) == $start_time ? 'selected' : '' }}>
                                        {{ $start_time }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('start_time')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="end_time">End Time</label>
                                <select class="form-control" id="end_time" name="end_time">
                                    @foreach($end_times as $end_time)
                                    <option value="{{ $end_time }}" {{ old('end_time', date('h:i A', strtotime($doctor->doctorDetail->end_time))) == $end_time ? 'selected' : '' }}>
                                        {{ $end_time }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('end_time')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="consultation_fee">Consultation Fee</label>
                                <input type="text" class="form-control" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee', $doctor->doctorDetail->consultation_fee) }}" placeholder="Fee should be between Rs.500 and Rs.5000" />
                                @error('consultation_fee')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="tab-pane fade" id="step3">
                        <h3 class="my-2 text-center">Personal Info</h3>

                        <div class="form-group">
                            <label for="education">Education</label>
                            <select class="form-control" id="education" name="education_id">
                                @foreach($educations as $education)
                                <option value="{{ $education->id }}" {{ old('education_id', $doctor->doctorDetail->education_id) == $education->id ? 'selected' : '' }}>
                                    {{ $education->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('education_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="experience">Experience</label>
                            <input type="text" class="form-control" id="experience" name="experience" value="{{ old('experience', $doctor->doctorDetail->experience) }}" placeholder="Experience in years" />
                            @error('experience')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob', $doctor->doctorDetail->dob) }}" min="{{ date('Y-m-d', strtotime("-80 years", strtotime(date('Y-m-d')))) }}" max="{{ date('Y-m-d', strtotime("-20 years", strtotime(date('Y-m-d')))) }}" />
                            @error('dob')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group radiobutton-container">
                            <label>Gender</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="gender_male" name="gender" value="Male" {{ old('gender', $doctor->doctorDetail->gender) == 'Male' ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="gender_male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="gender_female" name="gender" value="Female" {{ old('gender', $doctor->doctorDetail->gender) == 'Female' ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="gender_female">Female</label>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary update-btn" value="Update" name="submit" />
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


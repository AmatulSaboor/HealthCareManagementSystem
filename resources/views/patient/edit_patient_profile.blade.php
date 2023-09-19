<div class="form-group">
@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container" class ="index">
    <!-- Error Message -->
    @if(session()->get('error_message'))
    <div class="alert alert-danger">{{session()->get('error_message')}}</div>
    @endif

    <!-- Patient Profile Update Form -->
    <h4>Update Profile</h4>
    <form action="{{url('patient'.'/'.$patient->id)}}" method="POST" class="form-container">
        @csrf
        @method('put')
        <div class="container mt-4">
            <div class="row">
                <div class="col">
                    <!-- Stepper -->
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

                        <!-- Registeration Info Tab -->
                        <div class="tab-pane fade show active" id="step1">
                            <h3 class="my-2 text-center">Registration Info</h3>
                            <div class="form-group">
                                <label for="first_name">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name) }}" placeholder="Enter first name" />
                                @error('first_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name) }}" placeholder="Enter last name" />
                                @error('last_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Health Info Tab -->
                        <div class="tab-pane fade" id="step2">
                            <h3 class="my-2 text-center">Health Info</h3>
                            <div class="form-group">
                                <label for="weight">Weight (in kgs) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="weight" name="weight" value="{{ old('weight', $patient->patientDetail->weight) }}" placeholder="Enter weight" />
                                @error('weight')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="height">Height <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="height" name="height" value="{{ old('height', $patient->patientDetail->height) }}" placeholder="Enter height" />
                                @error('height')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="allergies">Allergies <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="allergies" name="allergies" value="{{ old('allergies', $patient->patientDetail->allergies) }}" placeholder="Specify allergies if any" />
                                @error('allergies')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group checkbox-container d-block">
                                <label>Please check <span class="text-danger">*</span></label>
                                <div class="form-check d-block">
                                    <input class="form-check-input" type="checkbox" id="is_BP_patient" name="is_BP_patient" value="1" {{ old('is_BP_patient', $patient->patientDetail->is_BP_patient) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_BP_patient">BP patient</label>
                                    <input class="form-check-input" type="checkbox" id="is_heart_patient" name="is_heart_patient" value="1" {{ old('is_heart_patient', $patient->patientDetail->is_heart_patient) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_heart_patient">Heart Patient</label>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Info Tab -->
                        <div class="tab-pane fade" id="step3">
                            <h3 class="my-2 text-center">Personal Info</h3>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob', $patient->patientDetail->dob) }}" min="{{ date('Y-m-d', strtotime("-80 years", strtotime(date('Y-m-d')))) }}" max="{{ date('Y-m-d', strtotime("-20 years", strtotime(date('Y-m-d')))) }}" />
                                @error('dob')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $patient->patientDetail->phone_number) }}" placeholder="Enter phone number" />
                                @error('phone_number')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $patient->patientDetail->address) }}" placeholder="Enter address" />
                                @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $patient->patientDetail->city) }}" placeholder="Enter city" />
                                @error('city')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group radiobutton-container">
                                <label>Gender</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="gender_male" name="gender" value="Male" {{ old('gender', $patient->patientDetail->gender) == 'Male' ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="gender_male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="gender_female" name="gender" value="Female" {{ old('gender', $patient->patientDetail->gender) == 'Female' ? 'checked' : '' }}>
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
    <button class="btn btn-primary mt-3" id="prevBtn" onclick="prevStep()">Previous</button>
    <button class="btn btn-primary mt-3 ml-3" id="nextBtn" onclick="nextStep()">Next</button>
    <!-- <a href="{{url('patient/'.$patient->id)}}">Cancel</a> -->
    <a href="{{url('patient/'.$patient->id)}}" class="cancel-btn-profile"><button class="btn btn-primary mt-3 ml-3 cancel-btn-profile">Cancel </button></a>

</div>
@push('js')
<script src="{{asset('js/stepper.js')}}"></script>
<script>
$(document).ready(function() {
    $('#is_BP_patient').on('change', function() {
        if ($(this).is(':checked')) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
    });
});
</script>

@endpush
@endsection


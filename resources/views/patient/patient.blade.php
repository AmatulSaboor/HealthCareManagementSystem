@extends('layouts.app')
@push('css')
    <link href="{{ asset('css/table.css')}}" rel="stylesheet">
    <link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container">
    @if(session()->get('error_message'))
    <div class="alert alert-danger">{{session()->get('error_message')}}</div>
    @endif
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Upcoming 
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <h3 class="text-center">Total No of Patients: <strong>{{$response['patient_count']}}</strong></h3>
                    <a href="{{url('patient_lists')}}" class="text-white text-center d-block"><button class="btn btn-primary">Show the patients list</button></a>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Doctor
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <h3 class="text-center">Total No of Doctors: <strong>{{$response['doctor_count']}}</strong></h3>
                    <a href="{{url('doctor')}}" class="text-white text-center d-block"><button class="btn btn-primary">Show the Doctors list</button></a>
                    <a href="{{url('doctor/create')}}" class="text-white text-center d-block mt-2"><button class="btn btn-primary">+ Add Doctor</button></a>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Appoinment
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <h3 class="text-center">Total No of Appoinments: <strong>{{$response['appointment_count']}}</strong></h3>
                    <a href="{{url('appointment_lists')}}" class="text-white text-center d-block"><button class="btn btn-primary">Show the Appoinments list</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
@endpush
@endsection
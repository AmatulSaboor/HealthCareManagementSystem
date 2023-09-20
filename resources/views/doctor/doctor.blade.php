@extends('layouts.app')
@push('css')
    <link href="{{ asset('css/table.css')}}" rel="stylesheet">
    <link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container">
    <!-- Error Message -->
    @if(session()->get('error_message'))
    <div class="alert alert-danger">{{session()->get('error_message')}}</div>
    @endif
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Previous Appointments
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <h3 class="text-center">Total No of Previous Appointments : <strong>{{$response['prev_appointments_count']}}</strong></h3>
                    <a href="#" class="text-white text-center d-block"><button class="btn btn-primary">We are working on showing previous appointments here, bear with us!!</button></a>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Today's Appointment
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <h3 class="text-center">Total no of today's Appointments are : <strong>{{$response['todays_appointments_count']}}</strong></h3>
                    <a href="#" class="text-white text-center d-block"><button class="btn btn-primary">We are working on showing today's appointment here, bear with us!!</button></a>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Upcoming Appoinments
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <h3 class="text-center">Total No of Upcoming Appoinments: <strong>{{$response['upcoming_appointments_count']}}</strong></h3>
                    <a href="#" class="text-white text-center d-block"><button class="btn btn-primary">We are working on showing upcoming appointments here, bear with us!!</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
@endpush
@endsection
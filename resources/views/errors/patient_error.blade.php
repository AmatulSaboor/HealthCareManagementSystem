<div class="form-group">
    @extends('layouts.app')
    @push('css')
    <link href="{{ asset('css/table.css')}}" rel="stylesheet">
    <link href="{{ asset('css/form.css')}}" rel="stylesheet">
    @endpush
    @section('content')
    <div class="container" class ="index">
        <!-- Error Message -->
        <div class="alert alert-danger">{{$error_message}}</div>
        <div class="row">
            <div class="col-md-6 offset-md-3 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Oops! Something Went Wrong</h2>
                        <p class="card-text">We're sorry, but an error occurred while processing your request.</p>
                        <p class="card-text">If the error persist, contact admin.</p>
                        <a "{{url('patient')}}" class="btn btn-primary">Go to Homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    @endpush
    @endsection
        
@extends('layouts.app')
@push('css')
<link href="{{ asset('css/table.css')}}" rel="stylesheet">
<link href="{{ asset('css/form.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container" >

    <!-- Error Message -->
    @if(session()->get('error_message'))
    <div class="alert alert-danger">{{session()->get('error_message')}}</div>
    @endif

    <!-- Patients List Table -->
    <h3 class="d-flex align-items-end mb-0 font-weight-bold">Patients List</h3>  
    <div>
        @if($patients->isEmpty())
        <label class="null-check">No patients have registered yet</label>
        @else
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Weight</th>
                <th>Height</th>
                <th>Allergies</th>
                <th>BP Patient</th>
                <th>Heart Patient</th>
            </tr>
            @foreach($patients as $patient)
            <tr>
                <td>{{$patient->name}}</td>
                <td>{{$patient->email}}</td>
                @if($patient && $patient->patientDetail)
                <td>@calculateAge($patient->patientDetail->dob) years</td>
                <td>{{$patient->patientDetail->gender}}</td>
                <td>{{$patient->patientDetail->weight}} kgs</td>
                <td>{{$patient->patientDetail->height}}</td>
                <td>{{$patient->patientDetail->allergies}}</td>
                <td>{{$patient->patientDetail->is_BP_patient? 'Yes' : 'No'}}</td>
                <td>{{$patient->patientDetail->is_heart_patient? 'Yes' : 'No'}}</td>
                @endif
            </tr>
            @endforeach
        </table>
        @endif
    </div>
</div>
{{ $patients->links() }}

@push('js')
@endpush
@endsection
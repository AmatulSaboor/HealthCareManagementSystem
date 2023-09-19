<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;

Auth::routes();
Route::get('/', function () {
    if (Auth::check()) {
        switch (Auth::user()->role_id) {
            case Role::ROLE_ADMIN:
                return redirect('/admin');
            case Role::ROLE_DOCTOR:
                return redirect('/doctor_dashboard');
            case Role::ROLE_PATIENT:
                return redirect('/patient');
        }
    } else {
        return redirect('/login');
    }
});
Route::group(
    ['middleware' => ['auth']],
    function () {
        Route::group(['middleware' => 'role:' . Role::ROLE_ADMIN], function () {
            Route::get('/admin', [AdminController::class, 'index']);
            Route::resource('/doctor', DoctorController::class);
            Route::get('/patient_lists', [AdminController::class, 'get_patients']);
            Route::get('/show_patient/{id}', [AdminController::class, 'show_patient']);
            Route::get('/appointment_lists', [AdminController::class, 'get_appointments']);
            Route::delete('/delete_appointment/{id}', [AdminController::class, 'delete_appointment']);
            Route::get('/send_cancellation_mail', [EmailController::class, 'send_cancellation_mail']);
        });
        Route::group(['middleware' => 'role:' . Role::ROLE_DOCTOR], function () {
            Route::get('/doctor_dashboard', [DoctorController::class, 'doctor']);
            Route::get('/doctor_appointments', [DoctorController::class, 'get_appointments']);
            Route::get('/doctor_patient/{id}', [DoctorController::class, 'get_patient']);
        });
        Route::group(['middleware' => 'role:' . Role::ROLE_PATIENT], function () {
            Route::resource('patient', PatientController::class);
            Route::resource('appointment', AppointmentController::class);
            Route::get('/send_confirmation_mail/{appointment_id}', [EmailController::class, 'send_confirmation_mail']);
            Route::get('/get_doctors_by_field/{field_id}', [AppointmentController::class, 'get_doctors_by_field']);
            Route::get('/get_time_intervals_by_doctor_id/{doctor_id}', [AppointmentController::class, 'get_time_intervals_by_doctor_id']);
            Route::get('/get_working_days_by_doctor_id/{doctor_id}', [AppointmentController::class, 'get_working_days_by_doctor_id']);
        });
    }
);
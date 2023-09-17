<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use App\Models\Role;

Auth::routes();
Route::get('/', function () {
    if (Auth::check()) {
        switch (Auth::user()->role_id) {
            case Role::ROLE_ADMIN:
                return redirect('/admin_dashboard');
            case Role::ROLE_DOCTOR:
                return redirect('/doctor_dashboard');
            case Role::ROLE_PATIENT:
                return redirect('/patient_dashboard');
        }
    } else {
        return redirect('/login');
    }
});
Route::group(
    ['middleware' => ['auth']],
    function () {
        Route::group(['middleware' => 'role:' . Role::ROLE_ADMIN], function () {
            Route::get('/admin_dashboard', [AdminController::class, 'index']);
            Route::resource('/doctor', DoctorController::class);
        });
        Route::group(['middleware' => 'role:' . Role::ROLE_DOCTOR], function () {
            Route::get('/doctor_dashboard', [DoctorController::class, 'doctor']);
        });
        Route::group(['middleware' => 'role:' . Role::ROLE_PATIENT], function () {
            Route::get('/patient_dashboard', [PatientController::class, 'index']);
            Route::resource('appointment', AppointmentController::class);
            Route::get('/get_doctors_by_field/{field_id}', [AppointmentController::class, 'get_doctors_by_field']);
            Route::get('/get_time_intervals_by_doctor_id/{doctor_id}', [AppointmentController::class, 'get_time_intervals_by_doctor_id']);
            Route::get('/get_working_days_by_doctor_id/{doctor_id}', [AppointmentController::class, 'get_working_days_by_doctor_id']);
            Route::get('/send_email/{appointment_id}', [EmailController::class, 'send_mail']);
        });
    }
);
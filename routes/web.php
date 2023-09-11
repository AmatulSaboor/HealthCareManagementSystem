<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', function () {
    if (Auth::check()) {
        switch (Auth::user()->role_id) {
            case Role::ROLE_ADMIN:
                // return redirect('/admin_dashboard');
                return redirect('/doctor');
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
        Route::group(['middleware' => 'role:'.Role::ROLE_ADMIN], function () {
            Route::resource('doctor', AdminController::class);
            // Route::get('/admin_dashboard', [AdminController::class, 'index']);
            // Route::get('/show_doctors', [AdminController::class, 'index_doctor']);
            // Route::delete('/delete_doctor/{id}', [AdminController::class, 'destroy_doctor']);
            // Route::get('/edit_doctor/{id}', [AdminController::class, 'edit_doctor']);
            // Route::put('/update_doctor/{id}', [AdminController::class, 'update_doctor']);
            // Route::post('/store_doctor', [AdminController::class, 'store_doctor']);
            // Route::get('/create_doctor', [AdminController::class, 'create_doctor']);
        });
        Route::group(['middleware' => 'role:'.Role::ROLE_DOCTOR], function () {
            Route::get('/doctor_dashboard', [DoctorController::class, 'index']);
        });
        Route::group(['middleware' => 'role:'.Role::ROLE_PATIENT], function () {
            Route::get('/patient_dashboard', [PatientController::class, 'index']);
            Route::get('/create_appointment', [PatientController::class, 'create_appointment']);
            Route::post('/store_appointment', [PatientController::class, 'store_appointment']);
            Route::get('/get_doctors_by_field/{field_id}', [PatientController::class, 'get_doctor_by_field']);
        });
    }
);
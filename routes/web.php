<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    // لوحة التحكم الرئيسية
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->isDoctor()) {
            return redirect()->route('doctor.dashboard');
        } elseif ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('patient.dashboard');
        }
    })->name('dashboard');

    // مسارات المريض
    Route::prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', function () {
            $user = auth()->user();
            $appointmentsCount = $user->appointmentsAsPatient()->count();
            $recordsCount = $user->medicalRecordsAsPatient()->count();
            return view('patient.dashboard', compact('appointmentsCount', 'recordsCount'));
        })->name('dashboard');

        Route::get('/appointments', [AppointmentController::class, 'myAppointments'])->name('appointments');
        Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('cancel-appointment');
        Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records');
        Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show'])->name('medical-record-detail');
    });

    // مسارات الطبيب
    Route::prefix('doctor')->name('doctor.')->middleware('role:doctor')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
        Route::get('/appointments/{id}', [DoctorController::class, 'appointmentDetail'])->name('appointment-detail');
        Route::post('/appointments/{id}/medical-record', [DoctorController::class, 'addMedicalRecord'])->name('add-medical-record');
        Route::post('/appointments/{id}/confirm', [DoctorController::class, 'confirmAppointment'])->name('confirm-appointment');
        Route::post('/appointments/{id}/cancel', [DoctorController::class, 'cancelAppointment'])->name('cancel-appointment');
        Route::get('/patient/{id}/records', [DoctorController::class, 'patientRecords'])->name('patient-records');
    });

    // مسارات الإدارة
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/departments', [AdminController::class, 'departments'])->name('departments');
        Route::post('/departments', [AdminController::class, 'storeDepartment'])->name('store-department');
        Route::put('/departments/{id}', [AdminController::class, 'updateDepartment'])->name('update-department');
        Route::delete('/departments/{id}', [AdminController::class, 'deleteDepartment'])->name('delete-department');
        Route::get('/doctors', [AdminController::class, 'doctors'])->name('doctors');
        Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
    });

    // مسارات الحجز
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/search', [AppointmentController::class, 'searchDoctors'])->name('search');
        Route::get('/doctor/{id}', [AppointmentController::class, 'doctorDetail'])->name('doctor-detail');
        Route::get('/doctor/{id}/book', [AppointmentController::class, 'bookingForm'])->name('booking-form');
        Route::get('/doctor/{id}/slots', [AppointmentController::class, 'availableSlots'])->name('available-slots');
        Route::post('/store', [AppointmentController::class, 'store'])->name('store');
    });

    // مسارات الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
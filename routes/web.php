<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Patient\AiHealthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecializationController;
use App\Models\User;
use App\Enums\UserRoleEnum;
use Illuminate\Support\Facades\Hash;

// Temporary route to create admin user - DELETE THIS AFTER USE
Route::get('/create-admin-secret-99', function () {
    $user = User::create([
        'name' => 'Rawan',
        'email' => 'rawanaltayyan3@gmail.com',
        'password' => Hash::make('rawan&&2026'),
        'role' => UserRoleEnum::Admin,
        'phone' => '0590000000', // Added dummy phone as it might be required
    ]);
    return 'Admin user created successfully! You can now login with: rayapalinfo@gmail.com';
});

Route::get('/locale/{locale}', LocaleController::class)->name('locale.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/services/emergency', function () {
    return view('services.emergency');
})->name('services.emergency');
Route::get('/services/lab', function () {
    return view('services.lab');
})->name('services.lab');
Route::get('/services/radiology', function () {
    return view('services.radiology');
})->name('services.radiology');
Route::get('/services/pharmacy', function () {
    return view('services.pharmacy');
})->name('services.pharmacy');

Route::get('/services', function () {
    return view('services.index');
})->name('services.index');

Route::get('/consultations', function () {
    return view('consultations.index');
})->name('consultations.index');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Secret Admin Path (You can change 'my-secret-admin-area' to anything you like)
$adminPath = env('ADMIN_PATH', 'my-secret-admin-area');
$ownerEmail = env('ADMIN_OWNER_EMAIL', 'admin@example.com');

Route::middleware(['auth', 'role:admin,receptionist', "owner:$ownerEmail"])->prefix($adminPath)->group(function () {
    Route::resource('departments', DepartmentController::class)->names([
        'index' => 'admin.departments.index',
        'create' => 'admin.departments.create',
        'store' => 'admin.departments.store',
        'edit' => 'admin.departments.edit',
        'update' => 'admin.departments.update',
        'destroy' => 'admin.departments.destroy',
    ]);

    Route::resource('specializations', SpecializationController::class)->names([
        'index' => 'admin.specializations.index',
        'create' => 'admin.specializations.create',
        'store' => 'admin.specializations.store',
        'edit' => 'admin.specializations.edit',
        'update' => 'admin.specializations.update',
        'destroy' => 'admin.specializations.destroy',
    ]);
});

Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/appointments', [PatientController::class, 'appointments'])->name('patient.appointments');
    Route::post('/patient/appointments/{appointment}/cancel', [PatientController::class, 'cancelAppointment'])->name('patient.cancel-appointment');
    Route::get('/patient/medical-records', [PatientController::class, 'medicalRecords'])->name('patient.medical-records');
    Route::get('/patient/medical-records/{record}', [PatientController::class, 'medicalRecordDetail'])->name('patient.medical-record-detail');

    Route::get('/patient/ai/symptoms', [AiHealthController::class, 'symptomForm'])->name('patient.ai.symptoms');
    Route::post('/patient/ai/symptoms', [AiHealthController::class, 'symptomTriage'])->name('patient.ai.symptoms.submit');
    Route::get('/patient/ai/slot-suggestions', [AiHealthController::class, 'suggestSlots'])->name('patient.ai.slots');

    Route::get('/appointments/create/{doctor?}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::get('/appointments/book', function() {
        return view('appointments.index');
    })->name('appointments.book');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    
    Route::get('/my-medical-records', function() {
        return view('MedicalRecords.index');
    })->name('patient.medical_records_list');
    
    Route::get('/my-prescriptions', function() {
        return view('Prescriptions.index');
    })->name('patient.prescriptions_list');
});

Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorDashboardController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/appointments', [DoctorDashboardController::class, 'appointments'])->name('doctor.appointments');
    Route::get('/doctor/appointments/{appointment}', [DoctorDashboardController::class, 'appointmentDetail'])->name('doctor.appointment-detail');
    Route::post('/doctor/appointments/{appointment}/confirm', [DoctorDashboardController::class, 'confirmAppointment'])->name('doctor.confirm-appointment');
    Route::post('/doctor/appointments/{appointment}/cancel', [DoctorDashboardController::class, 'cancelAppointment'])->name('doctor.cancel-appointment');
    Route::post('/doctor/appointments/{appointment}/medical-record', [DoctorDashboardController::class, 'addMedicalRecord'])->name('doctor.add-medical-record');
    Route::get('/doctor/schedule', [DoctorDashboardController::class, 'schedule'])->name('doctor.schedule');
    Route::get('/doctor/patient-records', [DoctorDashboardController::class, 'patientRecords'])->name('doctor.patient-records');
});

Route::middleware(['auth', 'role:admin,receptionist', "owner:$ownerEmail"])->prefix($adminPath)->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
    Route::get('/doctors/create', [AdminController::class, 'createDoctor'])->name('admin.doctors.create');
    Route::post('/doctors', [AdminController::class, 'storeDoctor'])->name('admin.doctors.store');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::get('/departments', [AdminController::class, 'departments'])->name('admin.departments');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['post', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.change-password');
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\chatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SpecializationController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Services Pages
Route::get('/services/emergency', function() { return view('services.emergency'); })->name('services.emergency');
Route::get('/services/lab', function() { return view('services.lab'); })->name('services.lab');
Route::get('/services/radiology', function() { return view('services.radiology'); })->name('services.radiology');
Route::get('/services/pharmacy', function() { return view('services.pharmacy'); })->name('services.pharmacy');

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');

// مسارات المصادقة
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// إنشاء Admin (خاص للمطور)
Route::get('/create-admin', function () {
    $user = \App\Models\User::where('email', 'rawanalltayyan3@gmail.com')->first();

    if (!$user) {
        $user = \App\Models\User::create([
            'name' => 'rawan',
            'email' => 'rawanalltayyan3@gmail.com',
            'phone' => '0599954996', 
            'password' => \Illuminate\Support\Facades\Hash::make('rawan&&2026'),
            'role' => 'admin',
        ]);
    }

    auth()->login($user);
    return redirect()->route('admin.dashboard')->with('success', 'تم الدخول كأدمن بنجاح!');
});

// مسارات الأقسام والتخصصات (للـ Admin فقط)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin/departments', DepartmentController::class)->names([
        'index'   => 'admin.departments.index',
        'create'  => 'admin.departments.create',
        'store'   => 'admin.departments.store',
        'edit'    => 'admin.departments.edit',
        'update'  => 'admin.departments.update',
        'destroy' => 'admin.departments.destroy',
    ]);
    
    Route::resource('admin/specializations', SpecializationController::class)->names([
        'index'   => 'admin.specializations.index',
        'create'  => 'admin.specializations.create',
        'store'   => 'admin.specializations.store',
        'edit'    => 'admin.specializations.edit',
        'update'  => 'admin.specializations.update',
        'destroy' => 'admin.specializations.destroy',
    ]);
});

Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Protected Routes - Patient
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/appointments', [PatientController::class, 'appointments'])->name('patient.appointments');
    Route::post('/patient/appointments/{appointment}/cancel', [PatientController::class, 'cancelAppointment'])->name('patient.cancel-appointment');
    Route::get('/patient/medical-records', [PatientController::class, 'medicalRecords'])->name('patient.medical-records');
    Route::get('/patient/medical-records/{record}', [PatientController::class, 'medicalRecordDetail'])->name('patient.medical-record-detail');
    Route::get('/appointments/create/{doctor}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/search', [AppointmentController::class, 'search'])->name('appointments.search');
});

// Protected Routes - Doctor
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
    Route::get('/doctor/appointments/{appointment}', [DoctorController::class, 'appointmentDetail'])->name('doctor.appointment-detail');
    Route::post('/doctor/appointments/{appointment}/confirm', [DoctorController::class, 'confirmAppointment'])->name('doctor.confirm-appointment');
    Route::post('/doctor/appointments/{appointment}/cancel', [DoctorController::class, 'cancelAppointment'])->name('doctor.cancel-appointment');
    Route::post('/doctor/appointments/{appointment}/medical-record', [DoctorController::class, 'addMedicalRecord'])->name('doctor.add-medical-record');
    Route::get('/doctor/schedule', [DoctorController::class, 'schedule'])->name('doctor.schedule');
    Route::get('/doctor/patient-records', [DoctorController::class, 'patientRecords'])->name('doctor.patient-records');
});

// Protected Routes - Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
    Route::get('/admin/doctors/create', [AdminController::class, 'createDoctor'])->name('admin.doctors.create');
    Route::post('/admin/doctors', [AdminController::class, 'storeDoctor'])->name('admin.doctors.store');
    Route::get('/admin/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::get('/admin/departments', [AdminController::class, 'departments'])->name('admin.departments');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});

// Authentication Routes
require __DIR__.'/auth.php';

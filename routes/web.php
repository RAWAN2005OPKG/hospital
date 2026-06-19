<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\DepartmentController as PublicDepartmentController;
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
    $user = User::updateOrCreate(
        ['email' => 'rawanaltayyan3@gmail.com'],
        [
            'name' => 'Rawan',
            'password' => Hash::make('rawan&&2026'),
            'role' => UserRoleEnum::Admin,
            'phone' => '0590000000',
        ]
    );
    
    // Auto login the user
    auth()->login($user);
    
    return 'تم إنشاء/تحديث حساب الأدمن وتسجيل دخولك تلقائياً! يمكنك الآن الذهاب إلى لوحة التحكم.';
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

Route::middleware(['auth', 'role:admin,receptionist'])->prefix($adminPath)->as('admin.')->group(function () {
    // Basic Admin Routes
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Users Management - Supporting both 'admin.users' and 'admin.users.index'
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/index', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Doctors Management - Supporting both 'admin.doctors' and 'admin.doctors.index'
    Route::get('/doctors', [AdminController::class, 'doctors'])->name('doctors');
    Route::get('/doctors/index', [AdminController::class, 'doctors'])->name('doctors.index');
    Route::get('/doctors/create', [AdminController::class, 'createDoctor'])->name('doctors.create');
    Route::post('/doctors', [AdminController::class, 'storeDoctor'])->name('doctors.store');
    Route::get('/doctors/{doctor}/edit', [AdminController::class, 'editDoctor'])->name('doctors.edit');
    Route::patch('/doctors/{doctor}', [AdminController::class, 'updateDoctor'])->name('doctors.update');
    Route::delete('/doctors/{doctor}', [AdminController::class, 'destroyDoctor'])->name('doctors.destroy');
    
    // Departments - Supporting 'admin.departments' and 'admin.departments.index'
    Route::get('/departments', [AdminController::class, 'departments'])->name('departments');
    Route::get('/departments/index', [AdminController::class, 'departments'])->name('departments.index');
    Route::resource('departments', AdminDepartmentController::class)->except(['index'])->names([
        'create' => 'departments.create',
        'store' => 'departments.store',
        'edit' => 'departments.edit',
        'update' => 'departments.update',
        'destroy' => 'departments.destroy',
    ]);
    
    // Specializations - Supporting 'admin.specializations' and 'admin.specializations.index'
    Route::get('/specializations', [AdminController::class, 'specializations'])->name('specializations');
    Route::resource('specializations', SpecializationController::class)->names([
        'index' => 'specializations.index',
        'create' => 'specializations.create',
        'store' => 'specializations.store',
        'edit' => 'specializations.edit',
        'update' => 'specializations.update',
        'destroy' => 'specializations.destroy',
    ]);
});

Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
Route::get('/departments', [PublicDepartmentController::class, 'index'])->name('departments');
Route::get('/departments/{department}', [PublicDepartmentController::class, 'show'])->name('departments.show');
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
    Route::get('/doctor/consultations', [\App\Http\Controllers\ChatController::class, 'index'])->name('doctor.consultations');
    Route::get('/doctor/chat/{otherUser}', [\App\Http\Controllers\ChatController::class, 'show'])->name('doctor.chat.show');
    Route::post('/chat/store/{receiver}', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');

    });

// Old duplicate admin routes removed to prevent conflicts

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['post', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.change-password');
});

require __DIR__.'/auth.php';

// Contact Messages Routes (Admin Only)
Route::middleware(['auth', 'role:admin,receptionist'])->prefix($adminPath)->as('admin.')->group(function () {
    Route::get('/contact-messages', [AdminController::class, 'contactMessages'])->name('contact-messages');
});

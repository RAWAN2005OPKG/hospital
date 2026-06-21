<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\DepartmentController as PublicDepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
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

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

Route::get('/services/surgeries', function () {
    return redirect()->route('services.index')->withFragment('surgeries');
})->name('services.surgeries');

Route::get('/consultations', [\App\Http\Controllers\ConsultationController::class, 'index'])->name('consultations.index');

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

    // Medicines
    Route::resource('medicines', \App\Http\Controllers\Admin\MedicineController::class)->names([
        'index' => 'medicines.index',
        'create' => 'medicines.create',
        'store' => 'medicines.store',
        'edit' => 'medicines.edit',
        'update' => 'medicines.update',
        'destroy' => 'medicines.destroy',
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
        $patient = Auth::user()->patient;
        if (!$patient) {
            $prescriptions = collect();
        } else {
            $prescriptions = \App\Models\Prescription::where('patient_id', $patient->id)
                ->with(['medicines', 'doctor.user'])
                ->latest()
                ->get();
        }
        return view('Prescriptions.index', compact('prescriptions'));
    })->name('patient.prescriptions_list');

    Route::post('/patient/prescriptions/{prescription}/confirm', function (\App\Models\Prescription $prescription) {
        $patient = Auth::user()->patient;
        abort_unless($patient && $prescription->patient_id === $patient->id, 403);
        $prescription->update(['status' => 'confirmed']);
        return back()->with('success', 'تم تأكيد استلام الطلب بنجاح');
    })->name('patient.prescriptions.confirm');

    Route::get('/patient/consultations', [\App\Http\Controllers\ChatController::class, 'index'])->name('patient.consultations');
    Route::get('/patient/chat/{otherUser}', [\App\Http\Controllers\ChatController::class, 'show'])->name('patient.chat.show');
});

// Pharmacist Routes
Route::middleware(['auth', 'role:pharmacist'])->prefix('pharmacist')->as('pharmacist.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Pharmacist\DashboardController::class, 'dashboard'])->name('dashboard');
    
    // Prescriptions
    Route::get('/prescriptions', [\App\Http\Controllers\Pharmacist\PrescriptionController::class, 'index'])->name('prescriptions.index');
    Route::get('/prescriptions/{prescription}', [\App\Http\Controllers\Pharmacist\PrescriptionController::class, 'show'])->name('prescriptions.show');
    Route::post('/prescriptions/{prescription}/accept', [\App\Http\Controllers\Pharmacist\PrescriptionController::class, 'accept'])->name('prescriptions.accept');
    Route::post('/prescriptions/{prescription}/reject', [\App\Http\Controllers\Pharmacist\PrescriptionController::class, 'reject'])->name('prescriptions.reject');
    Route::post('/prescriptions/{prescription}/ready', [\App\Http\Controllers\Pharmacist\PrescriptionController::class, 'markAsReady'])->name('prescriptions.ready');
    Route::post('/prescriptions/{prescription}/deliver', [\App\Http\Controllers\Pharmacist\PrescriptionController::class, 'markAsDelivered'])->name('prescriptions.deliver');
    Route::post('/prescriptions/{prescription}/invoice', [\App\Http\Controllers\Pharmacist\PrescriptionController::class, 'createInvoice'])->name('prescriptions.create-invoice');
    
    // Inventory
    Route::get('/inventory', [\App\Http\Controllers\Pharmacist\InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [\App\Http\Controllers\Pharmacist\InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [\App\Http\Controllers\Pharmacist\InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{medicine}', [\App\Http\Controllers\Pharmacist\InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/inventory/{medicine}/edit', [\App\Http\Controllers\Pharmacist\InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{medicine}', [\App\Http\Controllers\Pharmacist\InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{medicine}', [\App\Http\Controllers\Pharmacist\InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::post('/inventory/{medicine}/stock', [\App\Http\Controllers\Pharmacist\InventoryController::class, 'updateStock'])->name('inventory.update-stock');
    
    // Invoices
    Route::get('/invoices', [\App\Http\Controllers\Pharmacist\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create', [\App\Http\Controllers\Pharmacist\InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [\App\Http\Controllers\Pharmacist\InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}', [\App\Http\Controllers\Pharmacist\InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/edit', [\App\Http\Controllers\Pharmacist\InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [\App\Http\Controllers\Pharmacist\InvoiceController::class, 'update'])->name('invoices.update');
    Route::post('/invoices/{invoice}/pay', [\App\Http\Controllers\Pharmacist\InvoiceController::class, 'markAsPaid'])->name('invoices.pay');
    Route::post('/invoices/{invoice}/cancel', [\App\Http\Controllers\Pharmacist\InvoiceController::class, 'cancel'])->name('invoices.cancel');
    Route::delete('/invoices/{invoice}', [\App\Http\Controllers\Pharmacist\InvoiceController::class, 'destroy'])->name('invoices.destroy');

    // Sales
    Route::get('/sales', [\App\Http\Controllers\Pharmacist\SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/{invoice}', [\App\Http\Controllers\Pharmacist\SalesController::class, 'show'])->name('sales.show');

    // Reports
    Route::get('/reports', [\App\Http\Controllers\Pharmacist\ReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/daily-sales', [\App\Http\Controllers\Pharmacist\ReportsController::class, 'dailySales'])->name('reports.daily-sales');
    Route::get('/reports/monthly-sales', [\App\Http\Controllers\Pharmacist\ReportsController::class, 'monthlySales'])->name('reports.monthly-sales');
    Route::get('/reports/top-selling', [\App\Http\Controllers\Pharmacist\ReportsController::class, 'topSellingMedicines'])->name('reports.top-selling');
    Route::get('/reports/low-stock', [\App\Http\Controllers\Pharmacist\ReportsController::class, 'lowStockMedicines'])->name('reports.low-stock');
    Route::get('/reports/expiring', [\App\Http\Controllers\Pharmacist\ReportsController::class, 'expiringMedicines'])->name('reports.expiring');
    Route::get('/reports/daily-sales/export', [\App\Http\Controllers\Pharmacist\ReportsController::class, 'exportDailySales'])->name('reports.daily-sales.export');
    Route::get('/reports/monthly-sales/export', [\App\Http\Controllers\Pharmacist\ReportsController::class, 'exportMonthlySales'])->name('reports.monthly-sales.export');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\Pharmacist\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-read', [\App\Http\Controllers\Pharmacist\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Pharmacist\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/system', [\App\Http\Controllers\Pharmacist\NotificationController::class, 'generateSystemNotifications'])->name('notifications.system');

    // Patients History
    Route::get('/patients', [\App\Http\Controllers\Pharmacist\PatientHistoryController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [\App\Http\Controllers\Pharmacist\PatientHistoryController::class, 'show'])->name('patients.show');
    Route::get('/patients/{patient}/prescriptions', [\App\Http\Controllers\Pharmacist\PatientHistoryController::class, 'prescriptionHistory'])->name('patients.prescriptions');
    Route::get('/patients/{patient}/invoices', [\App\Http\Controllers\Pharmacist\PatientHistoryController::class, 'invoiceHistory'])->name('patients.invoices');
    Route::get('/patients/{patient}/medicines', [\App\Http\Controllers\Pharmacist\PatientHistoryController::class, 'medicineHistory'])->name('patients.medicines');
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

    });

// Old duplicate admin routes removed to prevent conflicts

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['post', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.change-password');
    Route::post('/chat/store/{receiver}', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');
});

require __DIR__.'/auth.php';

// Contact Messages Routes (Admin Only)
Route::middleware(['auth', 'role:admin,receptionist'])->prefix($adminPath)->as('admin.')->group(function () {
    Route::get('/contact-messages', [AdminController::class, 'contactMessages'])->name('contact-messages');
    Route::post('/contact-messages/{message}/read', [AdminController::class, 'markContactMessageRead'])->name('contact-messages.read');
    Route::post('/contact-messages/{message}/reply', [AdminController::class, 'replyContactMessage'])->name('contact-messages.reply');
});

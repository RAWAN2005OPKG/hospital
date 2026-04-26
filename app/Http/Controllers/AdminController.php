<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalDoctors = Doctor::count();
        $totalAppointments = Appointment::count();
        $totalDepartments = Department::count();
        $totalUsers = User::count();
        
        $recentAppointments = Appointment::with('patient', 'doctor')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        $appointmentStats = [
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.dashboard', compact(
            'totalDoctors',
            'totalAppointments',
            'totalDepartments',
            'totalUsers',
            'recentAppointments',
            'appointmentStats'
        ));
    }
    
    public function doctors()
    {
        $doctors = Doctor::with('user', 'department', 'specialization')
            ->paginate(15);
        
        return view('admin.doctors', compact('doctors'));
    }
    
    public function appointments()
    {
        $appointments = Appointment::with('patient', 'doctor')
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);

        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $weekAppointments = Appointment::whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $monthAppointments = Appointment::whereMonth('appointment_date', now()->month)->whereYear('appointment_date', now()->year)->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        
        return view('admin.appointments', compact(
            'appointments', 
            'todayAppointments', 
            'weekAppointments', 
            'monthAppointments', 
            'pendingAppointments'
        ));
    }
    
    public function departments()
    {
        $departments = Department::withCount('doctors')->paginate(15, ['*'], 'departments_page');
        $specializations = \App\Models\Specialization::withCount('doctors')->paginate(15, ['*'], 'specs_page');
        
        return view('admin.departments', compact('departments', 'specializations'));
    }
    
    public function users()
    {
        $users = User::paginate(15);
        
        return view('admin.users', compact('users'));
    }

    public function createDoctor()
    {
        $departments = Department::all();
        $specializations = \App\Models\Specialization::all();
        return view('admin.doctors.create', compact('departments', 'specializations'));
    }

    public function storeDoctor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'specialization_id' => 'required|exists:specializations,id',
            'license_number' => 'required|string|unique:doctors',
            'experience_years' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'bio' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'department_id' => $validated['department_id'],
            'specialization_id' => $validated['specialization_id'],
            'license_number' => $validated['license_number'],
            'experience_years' => $validated['experience_years'],
            'consultation_fee' => $validated['consultation_fee'],
            'bio' => $validated['bio'],
        ]);

        return redirect()->route('admin.doctors')->with('success', 'تم إضافة الطبيب بنجاح');
    }
}
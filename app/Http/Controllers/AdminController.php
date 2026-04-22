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
        
        return view('admin.appointments', compact('appointments'));
    }
    
    public function departments()
    {
        $departments = Department::withCount('doctors')->paginate(15);
        
        return view('admin.departments', compact('departments'));
    }
    
    public function users()
    {
        $users = User::paginate(15);
        
        return view('admin.users', compact('users'));
    }
}
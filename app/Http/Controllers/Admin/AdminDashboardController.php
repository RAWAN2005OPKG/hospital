<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Enums\UserRoleEnum;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalDoctors = Doctor::count();
        $totalPatients = User::where("role", UserRoleEnum::Patient)->count();
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where("status", "pending")->count();

        return view("admin.dashboard", compact("totalUsers", "totalDoctors", "totalPatients", "totalAppointments", "pendingAppointments"));
    }

    public function users()
    {
        $users = User::orderBy("created_at", "desc")->paginate(10);
        return view("admin.users", compact("users"));
    }

    public function doctors()
    {
        $doctors = Doctor::with("user", "specialty", "department")->orderBy("created_at", "desc")->paginate(10);
        return view("admin.doctors", compact("doctors"));
    }

    public function appointments()
    {
        $appointments = Appointment::with("patient.user", "doctor.user")->orderBy("appointment_date", "desc")->paginate(10);
        return view("admin.appointments", compact("appointments"));
    }

    public function settings()
    {
        // Logic to retrieve and update settings
        return view("admin.settings");
    }

    public function departments()
    {
        // Logic to manage departments
        return view("admin.departments");
    }
}
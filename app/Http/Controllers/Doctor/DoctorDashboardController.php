<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Prescription;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;

        $todayAppointments = $doctor->appointments()
                                    ->where("appointment_date", now()->toDateString())
                                    ->count();

        $upcomingAppointments = $doctor->appointments()
                                        ->where("appointment_date", ">=", now()->toDateString())
                                        ->orderBy("appointment_date")
                                        ->orderBy("appointment_time")
                                        ->limit(5)
                                        ->get();

        $totalPatients = Patient::whereHas("appointments", function ($query) use ($doctor) {
            $query->where("doctor_id", $doctor->id);
        })->distinct("user_id")->count();

        $totalPrescriptions = $doctor->prescriptions()->count();

        return view("doctor.dashboard", compact("todayAppointments", "upcomingAppointments", "totalPatients", "totalPrescriptions"));
    }

    public function appointments()
    {
        $doctor = Auth::user()->doctor;
        $appointments = $doctor->appointments()->with("patient.user")->orderBy("appointment_date", "desc")->paginate(10);
        return view("doctor.appointments", compact("appointments"));
    }

    public function patientRecords()
    {
        $doctor = Auth::user()->doctor;
        $patients = Patient::whereHas("appointments", function ($query) use ($doctor) {
            $query->where("doctor_id", $doctor->id);
        })->with("user")->distinct("user_id")->paginate(10);
        return view("doctor.patient_records", compact("patients"));
    }

    public function prescriptions()
    {
        $doctor = Auth::user()->doctor;
        $prescriptions = $doctor->prescriptions()->with("patient.user")->orderBy("created_at", "desc")->paginate(10);
        return view("doctor.prescriptions", compact("prescriptions"));
    }

    public function chats()
    {
        $doctor = Auth::user()->doctor;
        $chats = $doctor->chats()->with("sender")->orderBy("created_at", "desc")->paginate(10);
        return view("doctor.chats", compact("chats"));
    }

    public function schedule()
    {
        $doctor = Auth::user()->doctor;
        $schedules = $doctor->schedules()->orderBy("day_of_week")->get();
        return view("doctor.schedule", compact("schedules"));
    }
}
<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\Invoice;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->patient;

        $upcomingAppointments = $patient->appointments()
                                        ->where("appointment_date", ">=", now()->toDateString())
                                        ->orderBy("appointment_date")
                                        ->orderBy("appointment_time")
                                        ->limit(5)
                                        ->get();

        $totalAppointments = $patient->appointments()->count();
        $medicalRecordsCount = $patient->medicalRecords()->count();
        
        // Pharmacy-related statistics
        $totalPrescriptions = $patient->prescriptions()->count();
        $pendingPrescriptions = $patient->prescriptions()->where('status', 'pending')->count();
        $readyPrescriptions = $patient->prescriptions()->where('status', 'ready')->count();
        $deliveredPrescriptions = $patient->prescriptions()->where('status', 'delivered')->count();
        $totalInvoices = Invoice::where('patient_id', Auth::id())->count();
        $pendingInvoices = Invoice::where('patient_id', Auth::id())->where('status', 'pending')->count();
        $paidInvoices = Invoice::where('patient_id', Auth::id())->where('status', 'paid')->count();

        return view("patient.dashboard", compact(
            "upcomingAppointments", 
            "totalAppointments", 
            "medicalRecordsCount",
            "totalPrescriptions",
            "pendingPrescriptions",
            "readyPrescriptions",
            "deliveredPrescriptions",
            "totalInvoices",
            "pendingInvoices",
            "paidInvoices"
        ));
    }

    public function appointments()
    {
        $patient = Auth::user()->patient;
        $appointments = $patient->appointments()->with("doctor.user", "doctor.specialty")->orderBy("appointment_date", "desc")->paginate(10);
        return view("patient.appointments", compact("appointments"));
    }

    public function medicalRecords()
    {
        $patient = Auth::user()->patient;
        $medicalRecords = $patient->medicalRecords()->with("doctor.user")->orderBy("created_at", "desc")->paginate(10);
        return view("patient.medical_records", compact("medicalRecords"));
    }

    public function prescriptions()
    {
        $patient = Auth::user()->patient;
        $prescriptions = $patient->prescriptions()->with("doctor.user")->orderBy("created_at", "desc")->paginate(10);
        return view("patient.prescriptions", compact("prescriptions"));
    }

    public function reports()
    {
        $patient = Auth::user()->patient;
        $reports = $patient->reports()->with("doctor.user")->orderBy("created_at", "desc")->paginate(10);
        return view("patient.reports", compact("reports"));
    }

    public function chats()
    {
        $patient = Auth::user()->patient;
        $chats = $patient->chats()->with("receiver")->orderBy("created_at", "desc")->paginate(10);
        return view("patient.chats", compact("chats"));
    }
}
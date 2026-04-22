<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        $upcomingAppointments = Appointment::where('patient_id', $user->id)
            ->where('appointment_date', '>=', today())
            ->count();
        
        $medicalRecords = MedicalRecord::where('patient_id', $user->id)->count();
        
        $totalAppointments = Appointment::where('patient_id', $user->id)->count();
        
        $appointments = Appointment::where('patient_id', $user->id)
            ->where('appointment_date', '>=', today())
            ->with('doctor')
            ->orderBy('appointment_date')
            ->take(5)
            ->get();
        
        return view('patient.dashboard', compact(
            'upcomingAppointments',
            'medicalRecords',
            'totalAppointments',
            'appointments'
        ));
    }
    
    public function appointments()
    {
        $user = auth()->user();
        $appointments = Appointment::where('patient_id', $user->id)
            ->with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);
        
        return view('patient.appointments', compact('appointments'));
    }
    
    public function cancelAppointment(Appointment $appointment)
    {
        if ($appointment->patient_id !== auth()->id()) {
            abort(403);
        }
        
        if ($appointment->status === 'completed' || $appointment->status === 'cancelled') {
            return redirect()->back()->with('error', 'لا يمكن إلغاء هذا الموعد');
        }
        
        $appointment->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'تم إلغاء الموعد بنجاح');
    }
    
    public function medicalRecords()
    {
        $user = auth()->user();
        $records = MedicalRecord::where('patient_id', $user->id)
            ->with('doctor', 'appointment')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('patient.medical-records', compact('records'));
    }
    
    public function medicalRecordDetail(MedicalRecord $record)
    {
        if ($record->patient_id !== auth()->id()) {
            abort(403);
        }
        
        $record->load('doctor', 'appointment', 'patient');
        
        return view('patient.medical-record-detail', compact('record'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with('user', 'specialization', 'department');
        
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }
        
        if ($request->specialization_id) {
            $query->where('specialization_id', $request->specialization_id);
        }
        
        $doctors = $query->paginate(12);
        $departments = Department::all();
        $specializations = Specialization::all();
        
        return view('doctors.index', compact('doctors', 'departments', 'specializations'));
    }
    
    public function show(Doctor $doctor)
    {
        $doctor->load('user', 'specialization', 'department');
        $schedules = Schedule::where('doctor_id', $doctor->id)->get();
        
        return view('doctors.show', compact('doctor', 'schedules'));
    }
    
    public function departments()
    {
        $departments = Department::withCount('doctors')->get();
        
        return view('departments.index', compact('departments'));
    }
    
    public function departmentShow(Department $department)
    {
        $doctors = $department->doctors()->with('user', 'specialization')->paginate(12);
        
        return view('departments.show', compact('department', 'doctors'));
    }
    
    // Doctor Dashboard
    public function dashboard()
    {
        $doctor = auth()->user()->doctor;
        
        $totalAppointments = Appointment::where('doctor_id', $doctor->id)->count();
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->count();
        $completedAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->count();
        $pendingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'pending')
            ->count();
        
        $schedules = Schedule::where('doctor_id', $doctor->id)->get();
        
        $todayAppointmentsList = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->with('patient')
            ->orderBy('appointment_time')
            ->get();
        
        return view('doctor.dashboard', compact(
            'doctor',
            'totalAppointments',
            'todayAppointments',
            'completedAppointments',
            'pendingAppointments',
            'schedules',
            'todayAppointmentsList'
        ));
    }
    
    public function appointments()
    {
        $doctor = auth()->user()->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);
        
        return view('doctor.appointments', compact('appointments'));
    }
    
    public function appointmentDetail(Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }
        
        $appointment->load('patient', 'doctor', 'medicalRecord');
        
        return view('doctor.appointment-detail', compact('appointment'));
    }
    
    public function confirmAppointment(Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }
        
        $appointment->update(['status' => 'confirmed']);
        
        return redirect()->back()->with('success', 'تم تأكيد الموعد بنجاح');
    }
    
    public function cancelAppointment(Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }
        
        $appointment->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'تم إلغاء الموعد');
    }
    
    public function addMedicalRecord(Request $request, Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        MedicalRecord::create([
            'appointment_id' => $appointment->id,
            'doctor_id' => auth()->user()->doctor->id,
            'patient_id' => $appointment->patient_id,
            'diagnosis' => $validated['diagnosis'],
            'treatment' => $validated['treatment'],
            'notes' => $validated['notes'] ?? null,
        ]);
        
        $appointment->update(['status' => 'completed']);
        
        return redirect()->back()->with('success', 'تم إضافة السجل الطبي بنجاح');
    }
    
    public function schedule()
    {
        $doctor = auth()->user()->doctor;
        $schedules = Schedule::where('doctor_id', $doctor->id)->get();
        
        return view('doctor.schedule', compact('schedules'));
    }
    
    public function patientRecords(Doctor $doctor)
    {
        if ($doctor->id !== auth()->user()->doctor->id) {
            abort(403);
        }
        
        $records = MedicalRecord::where('doctor_id', $doctor->id)
            ->with('patient')
            ->paginate(15);
        
        return view('doctor.patient-records', compact('records'));
    }
}
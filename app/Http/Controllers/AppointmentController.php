<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create(Doctor $doctor)
    {
        $doctor->load('user', 'specialization', 'department');
        $schedules = Schedule::where('doctor_id', $doctor->id)->get();
        
        return view('appointments.create', compact('doctor', 'schedules'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'reason' => 'nullable|string',
        ]);
        
        Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'reason' => $validated['reason'] ?? null,
            'status' => 'pending',
        ]);
        
        return redirect()->route('patient.appointments')
            ->with('success', 'تم حجز الموعد بنجاح');
    }

    public function search(Request $request)
    {
        $query = \App\Models\Doctor::with(['user', 'specialization', 'department']);

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('specialization_id')) {
            $query->where('specialization_id', $request->specialization_id);
        }

        $doctors = $query->paginate(9);

        $departments = \App\Models\Department::all();
        $specializations = \App\Models\Specialization::all();

        return view('appointments.search', compact('doctors', 'departments', 'specializations'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function create(Request $request, ?Doctor $doctor = null)
    {
        $specializations = Specialty::all();
        $doctors = Doctor::with('user', 'specialty')->get();

        $selectedDoctor = $doctor;
        if ($request->filled('doctor')) {
            $selectedDoctor = Doctor::with('user', 'specialty')->find($request->get('doctor'));
        }

        return view('appointments.create', compact('specializations', 'doctors', 'selectedDoctor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:500',
            'reason' => 'nullable|string|max:500',
        ]);

        $patient = Auth::user()->patient;
        abort_unless($patient, 403);

        $isAvailable = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->doesntExist();

        if (! $isAvailable) {
            throw ValidationException::withMessages([
                'appointment_time' => __('mediflow.slot_taken'),
            ]);
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
            'notes' => $request->notes,
            'reason' => $request->reason,
        ]);

        return redirect()->route('patient.dashboard')->with('success', __('mediflow.appointment_booked'));
    }

    public function show(Appointment $appointment)
    {
        // Ensure the authenticated user can view this appointment
        if (Auth::user()->isPatient() && Auth::user()->patient && Auth::user()->patient->id !== $appointment->patient_id) {
            abort(403);
        }
        if (Auth::user()->isDoctor() && Auth::user()->doctor->id !== $appointment->doctor_id) {
            abort(403);
        }

        return view("appointments.show", compact("appointment"));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            "status" => "required|in:pending,confirmed,cancelled,completed",
        ]);

        // Only doctor or admin can update status
        if (!Auth::user()->isDoctor() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $appointment->update(["status" => $request->status]);

        return back()->with("success", "تم تحديث حالة الموعد بنجاح.");
    }
}
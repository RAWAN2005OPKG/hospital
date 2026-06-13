<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends Controller
{
    public function dashboard()
    {
        return $this->index();
    }

    public function index()
    {
        $doctor = Auth::user()->doctor;
        abort_unless($doctor, 403);

        $todayAppointments = $doctor->appointments()
            ->where('appointment_date', now()->toDateString())
            ->count();

        $upcomingAppointments = $doctor->appointments()
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->with(['patient.user'])
            ->limit(5)
            ->get();

        $totalPatients = Patient::whereHas('appointments', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })->count();

        $totalPrescriptions = $doctor->prescriptions()->count();

        return view('doctor.dashboard', compact(
            'todayAppointments',
            'upcomingAppointments',
            'totalPatients',
            'totalPrescriptions'
        ));
    }

    public function appointments()
    {
        $doctor = Auth::user()->doctor;
        abort_unless($doctor, 403);
        $appointments = $doctor->appointments()
            ->with('patient.user')
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('doctor.appointments', compact('appointments'));
    }

    public function appointmentDetail(Appointment $appointment)
    {
        $this->assertOwnAppointment($appointment);
        $appointment->load(['patient.user', 'medicalRecord', 'doctor.user']);

        return view('admin.appointment-detail', compact('appointment'));
    }

    public function confirmAppointment(Appointment $appointment)
    {
        $this->assertOwnAppointment($appointment);
        abort_unless($appointment->isPending(), 403);

        $appointment->update(['status' => 'confirmed']);

        return back()->with('success', 'تم تأكيد الموعد.');
    }

    public function cancelAppointment(Request $request, Appointment $appointment)
    {
        $this->assertOwnAppointment($appointment);
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        if ($appointment->isCompleted() || $appointment->isCancelled()) {
            return back()->with('error', 'لا يمكن إلغاء هذا الموعد.');
        }

        $notes = trim((string) ($appointment->notes ?? ''));
        if ($request->filled('reason')) {
            $notes .= ($notes !== '' ? "\n" : '') . 'سبب الإلغاء: ' . $request->reason;
        }
        $appointment->update([
            'status' => 'cancelled',
            'notes' => $notes ?: $appointment->notes,
        ]);

        return back()->with('success', 'تم إلغاء الموعد.');
    }

    public function addMedicalRecord(Request $request, Appointment $appointment)
    {
        $this->assertOwnAppointment($appointment);

        if ($appointment->medicalRecord) {
            return back()->with('error', 'يوجد تقرير طبي مسجل لهذا الموعد.');
        }

        $validated = $request->validate([
            'diagnosis' => 'required|string|max:5000',
            'treatment' => 'required|string|max:5000',
            'prescription' => 'nullable|string|max:5000',
            'notes' => 'nullable|string|max:5000',
        ]);

        MedicalRecord::create([
            'patient_id' => $appointment->patient->user_id,
            'doctor_id' => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'diagnosis' => $validated['diagnosis'],
            'treatment' => $validated['treatment'],
            'prescription' => $validated['prescription'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        $appointment->update(['status' => 'completed']);

        return redirect()->route('doctor.appointments')->with('success', 'تم حفظ التقرير الطبي وإكمال الموعد.');
    }

    public function patientRecords()
    {
        $doctor = Auth::user()->doctor;
        abort_unless($doctor, 403);
        $patients = Patient::whereHas('appointments', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })->with('user')->paginate(10);

        return view('doctor.patient_records', compact('patients'));
    }

    public function schedule()
    {
        $doctor = Auth::user()->doctor;
        abort_unless($doctor, 403);
        $schedules = $doctor->schedules()->orderBy('day_of_week')->get();

        return view('doctor.schedule', compact('schedules'));
    }

    protected function assertOwnAppointment(Appointment $appointment): void
    {
        $doctor = Auth::user()->doctor;
        abort_unless($doctor && (int) $appointment->doctor_id === (int) $doctor->id, 403);
    }
}

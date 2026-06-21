<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Prescription;
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
        
        // إذا لم يكن هناك ملف طبيب مرتبط، نقوم بإنشائه فوراً لضمان عدم ظهور 403
        if (!$doctor && Auth::user()->isDoctor()) {
            $department = Department::first() ?? Department::create(['name' => 'قسم عام', 'manager_name' => 'مدير النظام', 'phone' => '0590000000']);
            $specialization = Specialization::first() ?? Specialization::create(['name' => 'تخصص عام']);
            
            $doctor = Doctor::create([
                'user_id' => Auth::id(),
                'specialization_id' => $specialization->id,
                'department_id' => $department->id,
                'license_number' => 'TEMP-' . Auth::id(),
                'experience_years' => 0,
                'bio' => '',
                'availability_status' => true,
                'consultation_fee' => 0,
            ]);
        }

        $todayAppointments = $doctor ? $doctor->appointments()->whereDate('appointment_date', now()->toDateString())->count() : 0;
        $upcomingAppointments = $doctor ? $doctor->appointments()->where('appointment_date', '>=', now()->toDateString())->with('patient.user')->limit(5)->get() : collect();
        $totalPatients = $doctor ? Patient::whereHas('appointments', function($q) use ($doctor) { $q->where('doctor_id', $doctor->id); })->count() : 0;
        $totalPrescriptions = $doctor ? $doctor->prescriptions()->count() : 0;
        
        // Pharmacy-related statistics
        $pendingPrescriptions = $doctor ? $doctor->prescriptions()->where('status', 'pending')->count() : 0;
        $deliveredPrescriptions = $doctor ? $doctor->prescriptions()->where('status', 'delivered')->count() : 0;
        $recentPatients = $doctor ? Patient::whereHas('appointments', function($q) use ($doctor) { 
            $q->where('doctor_id', $doctor->id); 
        })->with('user')->latest()->take(5)->get() : collect();

        return view('doctor.dashboard', [
            'totalAppointments' => $doctor ? $doctor->appointments()->count() : 0,
            'todayAppointments' => $todayAppointments,
            'completedAppointments' => $doctor ? $doctor->appointments()->where('status', 'completed')->count() : 0,
            'pendingAppointments' => $doctor ? $doctor->appointments()->where('status', 'pending')->count() : 0,
            'todayAppointmentsList' => $upcomingAppointments,
            'totalPatients' => $totalPatients,
            'totalPrescriptions' => $totalPrescriptions,
            'pendingPrescriptions' => $pendingPrescriptions,
            'deliveredPrescriptions' => $deliveredPrescriptions,
            'recentPatients' => $recentPatients
        ]);
    }

    public function appointments()
    {
        $doctor = Auth::user()->doctor;
        
        if (!$doctor && Auth::user()->isDoctor()) {
            return redirect()->route('doctor.dashboard');
        }

        $appointments = $doctor ? $doctor->appointments()
            ->with('patient.user')
            ->orderBy('appointment_date', 'desc')
            ->paginate(10) : collect();

        return view('doctor.appointments', compact('appointments'));
    }

    public function appointmentDetail(Appointment $appointment)
    {
        $this->assertOwnAppointment($appointment);
        $appointment->load(['patient.user', 'medicalRecord', 'doctor.user']);

        $medicines = \App\Models\Medicine::where('is_active', true)->get();

        return view('admin.appointment-detail', compact('appointment', 'medicines'));
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
            'medicines' => 'nullable|array',
            'medicines.*.id' => 'required_with:medicines|exists:medicines,id',
            'medicines.*.dosage' => 'required_with:medicines|string|max:255',
            'medicines.*.days' => 'required_with:medicines|integer|min:1',
            'medicines.*.notes' => 'nullable|string|max:500',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function() use ($validated, $appointment) {
            MedicalRecord::create([
                'patient_id' => $appointment->patient->user_id,
                'doctor_id' => $appointment->doctor_id,
                'appointment_id' => $appointment->id,
                'diagnosis' => $validated['diagnosis'],
                'treatment' => $validated['treatment'],
                'prescription' => $validated['prescription'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            if (!empty($validated['medicines'])) {
                $prescription = \App\Models\Prescription::create([
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $appointment->doctor_id,
                    'status' => 'pending',
                ]);

                $syncData = [];
                foreach ($validated['medicines'] as $med) {
                    $syncData[$med['id']] = [
                        'dosage' => $med['dosage'],
                        'days' => $med['days'],
                        'notes' => $med['notes'] ?? null,
                    ];
                }
                $prescription->medicines()->sync($syncData);
            }

            $appointment->update(['status' => 'completed']);
        });

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

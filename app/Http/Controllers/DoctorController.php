<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:doctor');
    }

    // لوحة تحكم الطبيب
    public function dashboard()
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();
        
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->where('status', '!=', 'cancelled')
            ->with('patient')
            ->orderBy('appointment_time')
            ->get();

        $stats = [
            'total_appointments' => Appointment::where('doctor_id', $doctor->id)->count(),
            'completed' => Appointment::where('doctor_id', $doctor->id)->where('status', 'completed')->count(),
            'pending' => Appointment::where('doctor_id', $doctor->id)->where('status', 'pending')->count(),
            'today_appointments' => $todayAppointments->count(),
        ];

        return view('doctor.dashboard', compact('doctor', 'todayAppointments', 'stats'));
    }

    // قائمة المواعيد
    public function appointments(Request $request)
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();
        
        $query = Appointment::where('doctor_id', $doctor->id)->with('patient');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(15);

        return view('doctor.appointments', compact('appointments'));
    }

    // تفاصيل الموعد
    public function appointmentDetail($id)
    {
        $appointment = Appointment::findOrFail($id);
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        if ($appointment->doctor_id !== $doctor->id) {
            abort(403, 'غير مصرح لك بالوصول إلى هذا الموعد');
        }

        return view('doctor.appointment-detail', compact('appointment'));
    }

    // إضافة تقرير طبي
    public function addMedicalRecord(Request $request, $appointmentId)
    {
        $request->validate([
            'diagnosis' => 'required|string|min:10',
            'treatment' => 'required|string|min:10',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($appointmentId);
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        if ($appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        if ($appointment->medicalRecord) {
            return redirect()->back()->with('error', 'تم إضافة تقرير طبي لهذا الموعد مسبقاً');
        }

        MedicalRecord::create([
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $doctor->id,
            'appointment_id' => $appointmentId,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'prescription' => $request->prescription,
            'notes' => $request->notes,
        ]);

        $appointment->update(['status' => 'completed']);

        return redirect()->route('doctor.appointments')->with('success', 'تم إضافة التقرير الطبي بنجاح');
    }

    // سجلات المريض
    public function patientRecords($patientId)
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();
        
        $records = MedicalRecord::where('patient_id', $patientId)
            ->where('doctor_id', $doctor->id)
            ->with('appointment')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('doctor.patient-records', compact('records', 'patientId'));
    }

    // تأكيد الموعد
    public function confirmAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        if ($appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        $appointment->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'تم تأكيد الموعد بنجاح');
    }

    // إلغاء الموعد
    public function cancelAppointment(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
        ]);

        $appointment = Appointment::findOrFail($id);
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        if ($appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        if ($appointment->status === 'completed') {
            return redirect()->back()->with('error', 'لا يمكن إلغاء موعد مكتمل');
        }

        $appointment->update([
            'status' => 'cancelled',
            'notes' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'تم إلغاء الموعد بنجاح');
    }
}
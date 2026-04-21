<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Department;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    // البحث عن الأطباء
    public function searchDoctors(Request $request)
    {
        $query = Doctor::query()->with('user', 'department', 'specialization');

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->specialization_id) {
            $query->where('specialization_id', $request->specialization_id);
        }

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $doctors = $query->paginate(12);
        $departments = Department::all();
        $specializations = Specialization::all();

        return view('appointments.search', compact('doctors', 'departments', 'specializations'));
    }

    // تفاصيل الطبيب
    public function doctorDetail($id)
    {
        $doctor = Doctor::findOrFail($id);
        $schedules = Schedule::where('doctor_id', $id)->get();
        $reviews = MedicalRecord::where('doctor_id', $id)->count();

        return view('appointments.doctor-detail', compact('doctor', 'schedules', 'reviews'));
    }

    // نموذج الحجز
    public function bookingForm($doctorId)
    {
        $doctor = Doctor::findOrFail($doctorId);
        return view('appointments.booking-form', compact('doctor'));
    }

    // الحصول على الفترات المتاحة
    public function availableSlots(Request $request, $doctorId)
    {
        $request->validate([
            'date' => 'required|date|after:today',
        ]);

        $doctor = Doctor::findOrFail($doctorId);
        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->dayOfWeek;

        $schedule = Schedule::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (!$schedule) {
            return response()->json(['slots' => [], 'message' => 'الطبيب لا يعمل في هذا اليوم']);
        }

        $bookedSlots = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_time')
            ->toArray();

        $slots = $this->generateTimeSlots(
            $schedule->start_time,
            $schedule->end_time,
            $schedule->break_start,
            $schedule->break_end,
            $bookedSlots
        );

        return response()->json(['slots' => $slots]);
    }

    // حفظ الحجز
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'reason' => 'nullable|string|max:500',
        ]);

        // التحقق من عدم وجود حجز مكرر
        $existing = Appointment::where('patient_id', auth()->id())
            ->where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'لديك حجز في نفس الوقت بالفعل');
        }

        Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('patient.appointments')->with('success', 'تم حجز الموعد بنجاح');
    }

    // مواعيدي
    public function myAppointments()
    {
        $appointments = Appointment::where('patient_id', auth()->id())
            ->with('doctor.user', 'doctor.department', 'medicalRecord')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        return view('appointments.my-appointments', compact('appointments'));
    }

    // إلغاء الموعد
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->patient_id !== auth()->id()) {
            abort(403);
        }

        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'لا يمكن إلغاء هذا الموعد');
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'تم إلغاء الموعد بنجاح');
    }

    // توليد الفترات الزمنية
    private function generateTimeSlots($start, $end, $breakStart, $breakEnd, $bookedSlots)
    {
        $slots = [];
        $current = strtotime($start);
        $endTime = strtotime($end);
        $breakStartTime = $breakStart ? strtotime($breakStart) : null;
        $breakEndTime = $breakEnd ? strtotime($breakEnd) : null;

        while ($current < $endTime) {
            $time = date('H:i', $current);

            if ($breakStartTime && $current >= $breakStartTime && $current < $breakEndTime) {
                $current += 30 * 60;
                continue;
            }

            if (!in_array($time, $bookedSlots)) {
                $slots[] = $time;
            }

            $current += 30 * 60;
        }

        return $slots;
    }
}
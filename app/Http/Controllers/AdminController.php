<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    // لوحة التحكم
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_doctors' => Doctor::count(),
            'total_patients' => User::where('role', 'patient')->count(),
            'total_appointments' => Appointment::count(),
            'total_departments' => Department::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
            'cancelled_appointments' => Appointment::where('status', 'cancelled')->count(),
        ];

        $recentAppointments = Appointment::with('patient', 'doctor.user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments'));
    }

    // الأقسام
    public function departments()
    {
        $departments = Department::withCount('doctors')->paginate(15);
        return view('admin.departments', compact('departments'));
    }

    // إضافة قسم
    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:departments',
            'description' => 'nullable|string',
        ]);

        Department::create($request->all());
        return redirect()->back()->with('success', 'تم إضافة القسم بنجاح');
    }

    // تعديل قسم
    public function updateDepartment(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:departments,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->all());

        return redirect()->back()->with('success', 'تم تحديث القسم بنجاح');
    }

    // حذف قسم
    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);
        
        if ($department->doctors()->count() > 0) {
            return redirect()->back()->with('error', 'لا يمكن حذف قسم يحتوي على أطباء');
        }

        $department->delete();
        return redirect()->back()->with('success', 'تم حذف القسم بنجاح');
    }

    // الأطباء
    public function doctors()
    {
        $doctors = Doctor::with('user', 'department', 'specialization')
            ->paginate(15);
        return view('admin.doctors', compact('doctors'));
    }

    // المواعيد
    public function appointments()
    {
        $appointments = Appointment::with('patient', 'doctor.user')
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);

        return view('admin.appointments', compact('appointments'));
    }

    // المستخدمين
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    // الإحصائيات
    public function statistics()
    {
        $appointmentsByStatus = Appointment::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        $appointmentsByDepartment = Doctor::selectRaw('department_id, count(appointments.id) as count')
            ->leftJoin('appointments', 'doctors.id', '=', 'appointments.doctor_id')
            ->groupBy('department_id')
            ->with('department')
            ->get();

        return view('admin.statistics', compact('appointmentsByStatus', 'appointmentsByDepartment'));
    }
}
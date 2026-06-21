<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('doctors')->get();

        $managers = [
            'emergency' => $this->findDepartment($departments, ['طوارئ', 'emergency']),
            'lab' => $this->findDepartment($departments, ['مختبر', 'تحاليل', 'lab']),
            'radiology' => $this->findDepartment($departments, ['أشعة', 'اشعة', 'radiology']),
            'pharmacy' => $this->findDepartment($departments, ['صيدل', 'pharmacy']),
            'outpatient' => $this->findDepartment($departments, ['عيادات', 'خارجي', 'outpatient', 'clinic']),
            'icu' => $this->findDepartment($departments, ['عناية', 'مركزة', 'icu', ' intensive']),
            'consultations' => $this->findDepartment($departments, ['استشارات', 'consultation']),
            'surgeries' => $this->findDepartment($departments, ['جراح', 'surgery', 'عمليات']),
        ];

        $patientAppointments = collect();
        if (Auth::check() && Auth::user()->isPatient() && Auth::user()->patient) {
            $patientAppointments = Appointment::where('patient_id', Auth::user()->patient->id)
                ->with(['doctor.user', 'doctor.department', 'doctor.specialization'])
                ->whereIn('status', ['pending', 'confirmed'])
                ->orderBy('appointment_date')
                ->get();
        }

        return view('services.index', compact('managers', 'patientAppointments'));
    }

    private function findDepartment($departments, array $keywords): ?Department
    {
        return $departments->first(function ($dept) use ($keywords) {
            $name = mb_strtolower($dept->name);
            foreach ($keywords as $keyword) {
                if (str_contains($name, mb_strtolower($keyword))) {
                    return true;
                }
            }
            return false;
        });
    }
}

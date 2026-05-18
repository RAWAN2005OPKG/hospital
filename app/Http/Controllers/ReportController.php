<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Enums\UserRoleEnum;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->isPatient()) {
            $reports = $user->patient->reports()->with("doctor.user")->orderBy("created_at", "desc")->paginate(10);
        } elseif ($user->isDoctor()) {
            $reports = $user->doctor->reports()->with("patient.user")->orderBy("created_at", "desc")->paginate(10);
        } elseif ($user->isAdmin()) {
            $reports = Report::with("patient.user", "doctor.user")->orderBy("created_at", "desc")->paginate(10);
        } else {
            $reports = collect();
        }
        return view("reports.index", compact("reports"));
    }

    public function create()
    {
        // Only doctors can create reports
        if (!Auth::user()->isDoctor()) {
            abort(403);
        }
        $patients = Patient::with("user")->get();
        return view("reports.create", compact("patients"));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isDoctor()) {
            abort(403);
        }

        $request->validate([
            "patient_id" => "required|exists:patients,id",
            "report_type" => "required|string|max:255",
            "report_file" => "required|file|mimes:pdf,doc,docx,jpg,png|max:10240", // Max 10MB
        ]);

        $reportPath = $request->file("report_file")->store("medical_reports", "public");

        Report::create([
            "patient_id" => $request->patient_id,
            "doctor_id" => Auth::user()->doctor->id,
            "report_type" => $request->report_type,
            "report_file" => $reportPath,
        ]);

        return redirect()->route("reports.index")->with("success", "تم رفع التقرير بنجاح.");
    }

    public function show(Report $report)
    {
        // Authorization logic
        if (Auth::user()->isPatient() && Auth::user()->patient->id !== $report->patient_id) {
            abort(403);
        }
        if (Auth::user()->isDoctor() && Auth::user()->doctor->id !== $report->doctor_id) {
            abort(403);
        }

        return view("reports.show", compact("report"));
    }

    public function download(Report $report)
    {
        // Authorization logic
        if (Auth::user()->isPatient() && Auth::user()->patient->id !== $report->patient_id) {
            abort(403);
        }
        if (Auth::user()->isDoctor() && Auth::user()->doctor->id !== $report->doctor_id) {
            abort(403);
        }

        return Storage::disk("public")->download($report->report_file, basename($report->report_file));
    }
}
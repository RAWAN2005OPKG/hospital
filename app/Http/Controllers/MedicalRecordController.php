<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // قائمة السجلات الطبية
    public function index()
    {
        $records = MedicalRecord::where('patient_id', auth()->id())
            ->with('doctor.user', 'appointment')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('medical-records.index', compact('records'));
    }

    // تفاصيل السجل الطبي
    public function show($id)
    {
        $record = MedicalRecord::findOrFail($id);

        if ($record->patient_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('medical-records.show', compact('record'));
    }

    // تحميل السجل الطبي
    public function download($id)
    {
        $record = MedicalRecord::findOrFail($id);

        if ($record->patient_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        // يمكن إضافة كود لتحميل PDF هنا
        return response()->download('path/to/file');
    }
}
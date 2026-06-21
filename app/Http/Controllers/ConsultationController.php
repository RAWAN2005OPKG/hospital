<?php

namespace App\Http\Controllers;

use App\Models\Doctor;

class ConsultationController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->isPatient()) {
            return redirect()->route('patient.consultations');
        }

        $doctors = Doctor::with('user', 'specialization')->limit(8)->get();

        return view('consultations.index', compact('doctors'));
    }
}

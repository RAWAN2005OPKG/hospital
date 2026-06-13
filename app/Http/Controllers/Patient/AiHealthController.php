<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Services\Ai\AppointmentSlotSuggestionService;
use App\Services\Ai\SymptomTriageService;
use Illuminate\Http\Request;

class AiHealthController extends Controller
{
    public function symptomForm()
    {
        return view('patient.ai-symptom-triage');
    }

    public function symptomTriage(Request $request, SymptomTriageService $triage)
    {
        $data = $request->validate([
            'symptoms' => 'required|string|min:5|max:2000',
        ]);

        $result = $triage->triage($data['symptoms']);

        return view('patient.ai-symptom-triage', compact('result'));
    }

    public function suggestSlots(Request $request, AppointmentSlotSuggestionService $slots)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $doctor = Doctor::findOrFail($data['doctor_id']);
        $suggestion = $slots->suggest($doctor, $data['date']);

        return response()->json($suggestion);
    }
}

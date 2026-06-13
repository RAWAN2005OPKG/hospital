<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\Report;
use App\Models\Chat;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $patient = $user->patient;
        abort_unless($patient, 403);

        $pid = $patient->id;

        $upcomingAppointments = Appointment::where('patient_id', $pid)
            ->where('appointment_date', '>=', today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        $medicalRecordsCount = MedicalRecord::where('patient_id', $user->id)->count();
        $totalAppointments = Appointment::where('patient_id', $pid)->count();
        $appointments = Appointment::where('patient_id', $pid)
            ->where('appointment_date', '>=', today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->with('doctor.user', 'doctor.specialization')
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        return view(
            "patient.dashboard",
            compact(
                "upcomingAppointments",
                "medicalRecordsCount",
                "totalAppointments",
                "appointments"
            )
        );
    }

    public function appointments()
    {
        $user = Auth::user();
        $patient = $user->patient;
        abort_unless($patient, 403);

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor.user', 'doctor.specialization')
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);

        return view('patient.appointments', compact('appointments'));
    }

    public function cancelAppointment(Appointment $appointment)
    {
        $patient = Auth::user()->patient;
        abort_unless($patient, 403);

        if ((int) $appointment->patient_id !== (int) $patient->id) {
            abort(403);
        }

        if ($appointment->status === 'completed' || $appointment->status === 'cancelled') {
            return redirect()
                ->back()
                ->with('error', 'لا يمكن إلغاء هذا الموعد');
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()
            ->back()
            ->with('success', 'تم إلغاء الموعد بنجاح');
    }

    public function medicalRecords()
    {
        $user = Auth::user();
        $records = MedicalRecord::where("patient_id", $user->id)
            ->with("doctor.user", "appointment")
            ->orderBy("created_at", "desc")
            ->paginate(15);

        return view("patient.medical-records", compact("records"));
    }

    public function medicalRecordDetail(MedicalRecord $record)
    {
        if ($record->patient_id !== Auth::id()) {
            abort(403);
        }
        $record->load("doctor.user", "appointment", "patient.user");

        return view("patient.medical-record-detail", compact("record"));
    }

    public function prescriptions()
    {
        $user = Auth::user();
        $prescriptions = Prescription::where("patient_id", $user->id)
            ->with("doctor.user")
            ->orderBy("created_at", "desc")
            ->paginate(15);

        return view("patient.prescriptions", compact("prescriptions"));
    }

    public function reports()
    {
        $user = Auth::user();
        $reports = Report::where("patient_id", $user->id)
            ->with("doctor.user")
            ->orderBy("created_at", "desc")
            ->paginate(15);

        return view("patient.reports", compact("reports"));
    }

    public function downloadReport(Report $report)
    {
        if ($report->patient_id !== Auth::id()) {
            abort(403);
        }

        return Storage::download($report->report_file);
    }

    public function chats()
    {
        $user = Auth::user();
        $chats = Chat::where("sender_id", $user->id)
            ->orWhere("receiver_id", $user->id)
            ->with("sender", "receiver")
            ->orderBy("created_at", "desc")
            ->get()
            ->groupBy(function ($chat) use ($user) {
                return $chat->sender_id === $user->id
                    ? $chat->receiver_id
                    : $chat->sender_id;
            });

        return view("patient.chats", compact("chats"));
    }

    public function showChat(User $otherUser)
    {
        $user = Auth::user();
        $messages = Chat::where(function ($query) use ($user, $otherUser) {
            $query
                ->where("sender_id", $user->id)
                ->where("receiver_id", $otherUser->id);
        })
            ->orWhere(function ($query) use ($user, $otherUser) {
                $query
                    ->where("sender_id", $otherUser->id)
                    ->where("receiver_id", $user->id);
            })
            ->orderBy("created_at", "asc")
            ->get();

        // Mark messages as read
        Chat::where("receiver_id", $user->id)
            ->where("sender_id", $otherUser->id)
            ->update(["is_read" => true]);

        return view("patient.chat-detail", compact("otherUser", "messages"));
    }

    public function sendMessage(Request $request, User $receiver)
    {
        $request->validate([
            "message" => "nullable|string",
            "attachment" => "nullable|file|mimes:jpg,jpeg,png,pdf|max:2048",
        ]);

        if (!$request->message && !$request->hasFile("attachment")) {
            return back()->with("error", "الرسالة أو المرفق مطلوب");
        }

        $attachmentPath = null;
        if ($request->hasFile("attachment")) {
            $attachmentPath = $request->file("attachment")->store("chat_attachments");
        }

        Chat::create([
            "sender_id" => Auth::id(),
            "receiver_id" => $receiver->id,
            "message" => $request->message,
            "attachment" => $attachmentPath,
        ]);

        // TODO: Send real-time notification to receiver

        return back()->with("success", "تم إرسال الرسالة");
    }

    public function payments()
    {
        $user = Auth::user();
        $payments = Payment::where("patient_id", $user->id)
            ->orderBy("created_at", "desc")
            ->paginate(15);

        return view("patient.payments", compact("payments"));
    }
}
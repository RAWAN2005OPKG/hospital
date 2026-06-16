<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function show()
    {
        return view("contact");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email",
            "subject" => "required|string|max:255",
            "message" => "required|string",
        ]);

        // Save message to database
        $contactMessage = ContactMessage::create($validated);

        // Send email to admin
        try {
            Mail::to(config('mail.from.address'))->send(new ContactFormMail($validated));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Contact form email failed: ' . $e->getMessage());
        }

        return redirect()
            ->back()
            ->with("success", "تم إرسال رسالتك بنجاح. سنتواصل معك قريباً.");
    }
}
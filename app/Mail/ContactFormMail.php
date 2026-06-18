<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Message;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array{ name: string, email: string, subject: string, message: string }
     */
    public array $data;

    /**
     * @param array{ name: string, email: string, subject: string, message: string } $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject($this->data['subject'] ?? 'Contact Form')
            ->view('emails.contact-form')
            ->with($this->data);
    }
}


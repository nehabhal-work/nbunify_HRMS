<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BirthdayWishMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $client
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Happy Birthday! 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.birthday-wish',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

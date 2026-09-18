<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MagicLoginMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $token) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tautan Masuk Sistem Inventaris IT DAOP 5',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.magic_login',
            with: [
                'loginUrl' => url('/verify-login/' . $this->token),
                'name'     => $this->user->name,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

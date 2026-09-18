<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Invitation $invitation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Undangan Akses Sistem Inventaris IT DAOP 5',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invitation',
            with: [
                'invitationUrl' => url('/invite/'.$this->invitation->token),
                'name' => $this->invitation->name,
                'expiresAt' => $this->invitation->expires_at->format('d M Y, H:i'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

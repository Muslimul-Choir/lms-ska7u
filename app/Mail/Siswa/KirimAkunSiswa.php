<?php

namespace App\Mail\Siswa;

use App\Models\Siswa;
use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class KirimAkunSiswa extends Mailable
{

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Siswa   $siswa,
        public string $password
    )
    {
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informasi Akun LMS - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.siswa.akun',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

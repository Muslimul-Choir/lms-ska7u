<?php

namespace App\Mail\Guru;

use App\Models\Guru;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KirimAkunGuru extends Mailable
{
    use Queueable, SerializesModels;
 
    public function __construct(
        public Guru   $guru,
        public string $password   // plain password sebelum di-hash
    ) {}
 
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informasi Akun LMS - ' . config('app.name'),
        );
    }
 
    public function content(): Content
    {
        return new Content(
            view: 'emails.guru.akun',
        );
    }
}

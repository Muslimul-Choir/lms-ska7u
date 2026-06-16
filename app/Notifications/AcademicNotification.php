<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcademicNotification extends Notification
{
    use Queueable;

    protected $type;
    protected $title;
    protected $message;
    protected $url;
    protected $sendEmail;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $type, string $title, string $message, string $url, bool $sendEmail = false)
    {
        $this->type = $type;
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
        $this->sendEmail = $sendEmail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        // Only send email for materi, tugas, and kuis
        if ($this->sendEmail && $notifiable->email) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $siswaName = $notifiable->siswa?->nama_lengkap ?? $notifiable->name;
        $subjectPrefix = '';
        
        switch ($this->type) {
            case 'materi':
                $subjectPrefix = 'Materi Baru: ';
                $typeName = 'Materi Pembelajaran';
                break;
            case 'tugas':
                $subjectPrefix = 'Tugas Baru: ';
                $typeName = 'Tugas';
                break;
            case 'kuis':
                $subjectPrefix = 'Kuis Baru: ';
                $typeName = 'Kuis';
                break;
            default:
                $subjectPrefix = 'Notifikasi Akademik: ';
                $typeName = 'Konten';
        }

        return (new MailMessage)
            ->subject($subjectPrefix . $this->title)
            ->greeting('Halo, ' . $siswaName)
            ->line('Pemberitahuan baru dari portal LMS SKA7U Batam.')
            ->line("Terdapat {$typeName} baru yang telah diterbitkan:")
            ->line("**{$this->title}**")
            ->line($this->message)
            ->action('Buka LMS SKA7U', $this->url)
            ->line('Silakan login ke portal siswa Anda untuk melihat detail selengkapnya.')
            ->salutation('Salam hangat,' . "\n" . 'Tim LMS SMK Negeri 7 Batam');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
        ];
    }
}

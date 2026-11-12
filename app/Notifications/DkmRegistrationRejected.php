<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DkmRegistrationRejected extends Notification
{
    public const DEFAULT_REASON = 'Administrator tidak mencantumkan alasan spesifik.';

    public function __construct(
        public string $recipientName,
        public ?string $masjidName,
        public ?string $reason = null,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $reason = trim((string) $this->reason) !== '' ? trim($this->reason) : self::DEFAULT_REASON;
        $appName = config('app.name');
        $masjid = $this->masjidName ? ' atas nama ' . $this->masjidName : '';

        return (new MailMessage)
            ->subject('Pemberitahuan Penolakan Pendaftaran Akun - ' . $appName)
            ->greeting('Yth. ' . $this->recipientName . ',')
            ->line('Terima kasih telah mendaftar di ' . $appName . '. Dengan menyesal kami informasikan bahwa pendaftaran akun DKM Anda' . $masjid . ' **belum dapat disetujui** oleh administrator.')
            ->line('**Alasan penolakan:**')
            ->line($reason)
            ->line('Apabila Anda membutuhkan penjelasan lebih lanjut atau ingin memperbaiki data pendaftaran, silakan hubungi administrator dengan membalas email ini atau melalui kontak resmi kami.')
            ->salutation("Hormat kami,\nAdministrator " . $appName);
    }
}

<?php

namespace App\Notifications;

use App\Models\DaftarRisiko;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HighRiskRegisteredNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public DaftarRisiko $risk) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $riskLevel = $this->risk->tahap_risiko;
        $isHighRisk = in_array($riskLevel, ['Tinggi', 'Kritikal']);

        $message = (new MailMessage)
            ->subject('⚠️ Notifikasi Risiko ' . strtoupper($riskLevel) . ' Didaftar')
            ->greeting('Assalamualaikum Sistem Admin,')
            ->line('Risiko baru dengan tahap **' . $riskLevel . '** telah didaftarkan dalam sistem.')
            ->line('')
            ->line('📋 **Butiran Risiko:**')
            ->line('• **Agensi:** ' . ($this->risk->agency->nama_agensi ?? 'N/A'))
            ->line('• **Aset:** ' . ($this->risk->asset->nama_aset ?? 'N/A'))
            ->line('• **Risiko:** ' . ($this->risk->risiko->nama ?? 'N/A'))
            ->line('• **Impak:** ' . $this->risk->impak . ' / 5')
            ->line('• **Kebarangkalian:** ' . $this->risk->kebarangkalian . ' / 5')
            ->line('• **Skor Risiko:** ' . $this->risk->skor_risiko)
            ->line('• **Tahap Risiko:** ' . $riskLevel)
            ->line('• **Pemilik Risiko:** ' . ($this->risk->pemilik_risiko ?? '-'))
            ->line('')
            ->line('📝 **Pelan Mitigasi:**')
            ->line($this->risk->plan_mitigasi ? $this->risk->plan_mitigasi : 'Tiada pelan mitigasi yang ditetapkan')
            ->line('')
            ->action('Lihat Butiran Risiko', url('/admin/risks'))
            ->line('Terima kasih,')
            ->salutation('Sistem Pengurusan Risiko Quantum');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'risk_id' => $this->risk->id,
            'agency_name' => $this->risk->agency->nama_agensi,
            'risk_level' => $this->risk->tahap_risiko,
        ];
    }
}

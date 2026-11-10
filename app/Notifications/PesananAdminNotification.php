<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PesananAdminNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $idPesanan,
        public string $noResi,
        public string $jenis
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        if ($this->jenis === 'bukti_pembayaran') {
            $title = 'Pembayaran Menunggu Verifikasi';

            $message = 'Bukti pembayaran untuk pesanan '
                . $this->noResi
                . ' telah diunggah. Silakan lakukan verifikasi.';
        } else {
            $title = 'Pesanan Baru';

            $message = 'Pesanan '
                . $this->noResi
                . ' baru saja dibuat oleh pelanggan.';
        }

        return [
            'jenis' => $this->jenis,
            'title' => $title,
            'message' => $message,
            'id_pesanan' => $this->idPesanan,
            'no_resi' => $this->noResi,
            'url' => route(
                'admin.orders.show',
                $this->idPesanan
            ),
        ];
    }
}

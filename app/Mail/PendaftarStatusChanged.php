<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendaftarStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $calon;
    public $status;

    public function __construct($calon, $status)
    {
        $this->calon = $calon;
        $this->status = $status;
    }

    private function translateStatusLabel($s)
    {
        $s = strtolower($s);
        return $s === 'verified' ? 'Sudah terverifikasi' : ($s === 'rejected' ? 'Ditolak' : ($s === 'paid' ? 'Sudah dibayar' : 'Menunggu verifikasi'));
    }

    public function build()
    {
        $label = $this->translateStatusLabel($this->status);
        return $this->subject("Status Pendaftaran Anda: {$label}")
                    ->view('emails.pendaftar_status')
                    ->with(['statusLabel' => $label]);
    }
}

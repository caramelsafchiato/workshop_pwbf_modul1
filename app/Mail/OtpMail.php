<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otpCode; // Harus ada ini agar bisa dibaca di email

    public function __construct($otpCode)
    {
        $this->otpCode = $otpCode;
    }

    public function build()
    {
        return $this->subject('Kode Verifikasi Login Kamu')
                    ->html("<h3>Halo!</h3><p>Kode OTP kamu adalah: <b>{$this->otpCode}</b></p>");
    }
}
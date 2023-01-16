<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email, $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("[RegistEvent] Reset Password")
        ->view('mail.reset', [
            'email' => $this->email,
            'token' => $this->token
        ]);
    }
}

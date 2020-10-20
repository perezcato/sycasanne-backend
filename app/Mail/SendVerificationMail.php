<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected string $companyEmail;
    protected string $verificationToken;

    public function __construct(string $companyEmail,string $verificationToken)
    {
        $this->companyEmail = $companyEmail;
        $this->verificationToken = $verificationToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->companyEmail)
            ->subject('Verification Token')
            ->view('verification',[
                'verificationToken' => $this->verificationToken
            ]);
    }
}

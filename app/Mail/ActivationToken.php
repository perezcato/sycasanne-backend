<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationToken extends Mailable
{
    use Queueable, SerializesModels;



    private string $activationToken;

    public function __construct(string $activationToken)
    {
        $this->activationToken = $activationToken;
    }

    public function build(): self
    {
        return $this->from('perezcatoc@gmail.com')
            ->subject('Activation Token')
            ->view('mails.verify',[
                'activationToken' => $this->activationToken
            ]);
    }
}

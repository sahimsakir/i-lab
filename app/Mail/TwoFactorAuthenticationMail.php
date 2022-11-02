<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorAuthenticationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $two_factor_auth_token;

    /**
     * TwoFactorAuthenticationMail constructor.
     *
     * @param $two_factor_auth_token
     */
    public function __construct($two_factor_auth_token)
    {
        $this->two_factor_auth_token = $two_factor_auth_token;
    }

    /**
     * Build the message.
     *
     * @return \App\Mail\TwoFactorAuthenticationMail
     */
    public function build(): TwoFactorAuthenticationMail
    {
        return $this->view('email.two-factor-authentication')->subject(config('app.name').' - Your Two Factor Authentication Token');
    }
}

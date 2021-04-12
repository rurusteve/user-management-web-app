<?php

namespace Modules\Users\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Users\Entities\PasswordReset;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $passwordReset;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PasswordReset $passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $key = $this->passwordReset->reset_key;
        $url = route('auth.password-reset.reset', ['key' => $key]);

        return $this->view('authentication::emails.email-verification-mail')
            ->with([
                'url'  => $url,
            ]);
    }
}

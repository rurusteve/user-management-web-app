<?php

namespace Modules\Users\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Users\Entities\EmailVerification;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $emailVer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EmailVerification $emailVer)
    {
        $this->emailVer = $emailVer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $key = $this->emailVer->verification_key;
        $url = route('auth.email-verification.verify', ['key' => $key]);

        return $this->view('authentication::emails.email-verification-mail')
            ->with([
                'url'  => $url,
            ]);
    }
}

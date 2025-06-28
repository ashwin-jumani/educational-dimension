<?php

namespace Modules\LMS\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class RegistrationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(protected $user)
    {
        //
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        $url = url('verify-mail/' . $this->user['id'] . '/' . str_replace('/', '-', Hash::make($this->user['first_name'])));
        $subject = isset($this->user['type']) ? 'Resend Verification Email' : 'Apply Course';

        return $this->subject($subject)
            ->view('portal::mail.register', ['user' => $this->user, 'url' => $url]);
    }
}

<?php

namespace Modules\LMS\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticesMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(protected $notices)
    {
        //
    }

    /**
     * Build the message.
     */
    public function build(): self
    {

        return $this->subject($this->notices['title'])->view('portal::mail.notices', ['data' => $this->notices]);
    }
}

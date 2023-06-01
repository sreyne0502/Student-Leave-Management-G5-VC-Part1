<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class rejectMail extends Mailable
{
    use Queueable, SerializesModels;
     public $reject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reject)
    {
        $this->reject = $reject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('The result of request permission')
                    ->view('emails.rejectstudentMail');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
   
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Voice Email')->from('transmail@voicemail.b1communications.ca', 'B1communications')
                    ->view('emails.voice_mail');
    }
}

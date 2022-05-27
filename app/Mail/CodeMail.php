<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($codiceProprio,$codiciDelega)
    {
        $this->codiceProprio = $codiceProprio;
        $this->codiciDelega = $codiciDelega;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $codiceProprio = $this->codiceProprio;
        $codiciDelega = $this->codiciDelega;
        return $this->view('mail.InvioCodice',compact("codiceProprio","codiciDelega"));
    }
}

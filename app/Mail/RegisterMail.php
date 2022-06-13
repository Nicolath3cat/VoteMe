<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$password,$ruolo)
    {
        $this->email = $email;
        $this->password = $password;
        $this->ruolo = $ruolo;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->email;
        $password = $this->password;
        $ruolo = $this->ruolo;
        return $this->view('mail.NuovoUtente',compact("email","password","ruolo"));
    }
}

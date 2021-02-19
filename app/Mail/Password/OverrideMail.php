<?php

namespace App\Mail\Password;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OverrideMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $pass;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $pass)
    {
        $this->name = $name;
        $this->email = $email;
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Account Password Overridden on " . env('APP_NAME'))
                    ->markdown('mails.password.override', [
                        'name' => $this->name,
                        'email' => $this->email,
                        'pass' => $this->pass,
                    ]);
    }
}

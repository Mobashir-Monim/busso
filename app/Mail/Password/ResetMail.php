<?php

namespace App\Mail\Password;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $pass;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $pass)
    {
        $this->name = $name;
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Account Password Resetted on " . env('APP_NAME'))
                    ->markdown('mails.password.reset', [
                        'name' => $this->name,
                        'pass' => $this->pass,
                    ]);
    }
}

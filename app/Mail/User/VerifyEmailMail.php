<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $data['full_name'] = $data['user']->specificData->name.' ' . $data['user']->specificData->last_name;
        $this->data = $data;
    }

    public function build()
    {
        return $this->view('emails.user.verify-email');
    }
}

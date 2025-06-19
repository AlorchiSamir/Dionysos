<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Registration extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(Array $data)
    {
        $this->data = $data;
    }
    
    public function build()
    {
        return $this->from('samir.alorchi@gmail.com')->view('emails.message');
    }
}

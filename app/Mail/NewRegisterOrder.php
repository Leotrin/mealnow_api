<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewRegisterOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $data, $pass;
    public function __construct($data, $pass)
    {
        $this->data = $data;
        $this->pass = $pass;
    }
    public function build()
    {
        $data = $this->data;
        $pass = $this->pass;
        return  $this->subject('New order')->view('emails.new_user',compact('data','pass'));
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        //
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {      
     
        return $this
            ->from($address = 'mail.thirstydevs@gmail.com', $name = 'FoodLans')
            ->subject('Test Mail')->view('mainAdmin/notification/mailMessage')
            ->with([
            'content' => $this->content,           
            ]);
    }
}

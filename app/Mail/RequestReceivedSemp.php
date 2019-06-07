<?php

namespace App\Mail;

use App\Attorney;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestReceivedSemp extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct($request, $fields)
     {
         $this->attorney = $request;
         $this->fields = $fields;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
     {
       $this->from(env('FROM_EMAIL'))
       ->subject('Thanks!  We\'ve received your request')
       ->view('mail.requestreceievedsemp', ['attorney' => $this->attorney]);
     }
}

<?php

namespace App\Mail;

use App\Attorney;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $attorney;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct(Attorney $attorney, $fields)
     {
         $this->attorney = $attorney;
         $this->fields = $fields;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->from(env('FROM_EMAIL'))
                ->subject('Semper Home Loans: Attorney Approval Submission')
                ->view('mail.requestreceieved', ['attorney' => $this->attorney]);
    }
}

<?php

namespace App\Mail;

use App\Attorney;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestProcessedSemp extends Mailable
{
    use Queueable, SerializesModels;

    public $attorney;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct($request, $fields, $status)
     {
         $this->attorney = $request;
         $this->fields = $fields;
         $this->status = $status;
         switch ($this->status) {
           case '1':
             $this->content_semper_contact = 'A request for ' . $request->company_contact_name . ' of ' . $request->company_name . ' to become an approved attorney has been denied.';
             break;

           case '2':
              $this->content_semper_contact = 'A request for ' . $request->company_contact_name . ' of ' . $request->company_name . ' to become an approved attorney has been approved.';
           default:
             // code...
             break;
         }
     }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $this->from(env('FROM_EMAIL'))
                ->subject('Semper Home Loans Attorney Approval Status')
                ->view('mail.requestprocessed', ['content' => $this->content_semper_contact]);
    }
}

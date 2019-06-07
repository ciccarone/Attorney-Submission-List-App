<?php

namespace App\Mail;

use App\Attorney;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestProcessed extends Mailable
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
             $this->content_attorney = 'Unfortunately, your request to become an approved attorney has been denied.  If you have any questions please contact ' . $request->semper_contact;
             $this->content_semper_contact = 'A request for ' . $request->company_contact_name . ' of ' . $request->company_name . ' to become an approved attorney has been denied.';
             break;

           case '2':
              $this->content_attorney = 'Your request to become an approved attorney has been approved.  Your information will appear on the <a href="' . env('BASE_URL') . '/list/' . $request->state  . '">approved attorney list</a>';
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
                ->subject('To Att: Semper Home Loans Attorney Approval Status')
                ->view('mail.requestprocessed', ['content' => $this->content_attorney]);
    }
}

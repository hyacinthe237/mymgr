<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\ContactSubmission;

class SendContactSubmissionEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BookingCreated  $event
     * @return void
     */
    public function handle(ContactSubmission $event)
    {
        $form = $event->form;
        $sendTo = config('mail.to');

        Mail::to($sendTo)->queue(new \App\Mail\ContactEmail($form));
    }
}

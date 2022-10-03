<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCompletedEmailToChef extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        info('Sending booking completed email to chef ==> ' . $this->booking->chef->email);

        return $this->subject('Booking Completed')
            ->markdown('mails.bookings.completed-chef');
    }
}

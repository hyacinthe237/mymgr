<?php

namespace App\Listeners;

use App\Events\BookingCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendBookingCompletedNotification implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle(BookingCompleted $event)
    {
        $booking = $event->booking;
        $client  = $booking->client;
        $chef    = $booking->chef;

        Mail::to($chef->email)->queue(new \App\Mail\BookingCompletedEmailToChef($booking));
        Mail::to($client->email)->queue(new \App\Mail\BookingCompletedEmailToClient($booking));
    }
}

<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendBookingCreatedNotification implements ShouldQueue
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
    public function handle(BookingCreated $event)
    {
        $booking = $event->booking;
        $client  = $booking->client;
        $chef    = $booking->chef;

        Mail::to($chef->email)->queue(new \App\Mail\BookingRequestEmail($booking));
        Mail::to($client->email)->queue(new \App\Mail\BookingConfirmationEmail($booking));
    }
}

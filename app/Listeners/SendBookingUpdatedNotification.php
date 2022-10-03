<?php

namespace App\Listeners;

use App\Events\BookingUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBookingUpdatedNotification implements ShouldQueue
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
     * @param  BookingUpdated  $event
     * @return void
     */
    public function handle(BookingUpdated $event)
    {
        //
    }
}

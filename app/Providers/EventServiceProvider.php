<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners;
use App\Events;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        Events\BookingCreated::class => [
            Listeners\SendBookingCreatedNotification::class
        ],

        Events\BookingUpdated::class => [
            Listeners\SendBookingUpdatedNotification::class
        ],

        Events\BookingCompleted::class => [
            Listeners\SendBookingCompletedNotification::class
        ],

        Events\MessageReceived::class => [
            Listeners\SendMessageReceivedNotification::class
        ],

        Events\ContactSubmission::class => [
            Listeners\SendContactSubmissionEmail::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

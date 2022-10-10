<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TicketAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The notification from.
     *
     * @var string
     */
    public $from;

    /**
     * The notification ticket.
     *
     * @var string
     */
    public $ticket;


    /**
     * Create a notification instance.
     *
     * @param  User  $from the user who assigned the ticket
     * @param  Ticket  $ticket the ticket that has been mutated
     * @return void
     */
    public function __construct($from,$ticket)
    { 
        $this->from = $from;
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database','slack'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'from' => $this->from,
            'ticket' => $this->ticket,
         ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => ''.$this->from->firstname.' assigned the ticket #'. '"'.$this->ticket->number.' '.$this->ticket->title.'" to you '
         ]);
    }


    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    { 
    //dd($notifiable);
        return (new SlackMessage)
                    ->content($this->from->firstname.' assigned the ticket #'. '"'.$this->ticket->number.' '.$this->ticket->title.'" to '.$notifiable->firstname);
    }

}
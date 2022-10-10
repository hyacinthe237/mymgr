<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TicketStatusUpdated extends Notification implements ShouldQueue
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
     * @param  id  User $from the user who updated the status
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
        return  ['broadcast', 'database','slack'];
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
            'status' => $this->ticket->category->name,
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
            'message' => ''.$this->from->firstname.' updated the status of the ticket #'. '"'.$this->ticket->number.' '.$this->ticket->title.'" to '.$this->ticket->category->name
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
        return (new SlackMessage)
                    ->content(''.$this->from->firstname.' updated the status of the ticket #'. '"'.$this->ticket->number.' '.$this->ticket->title.'" to '.$this->ticket->category->name);
    }
}

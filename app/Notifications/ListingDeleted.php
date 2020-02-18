<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ListingDeleted extends Notification
{
    use Queueable;
    public $user;
    public $listing;
    


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$listing)
    {
        $this->user= $user;
        $this->listing = $listing;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello! '.$user->name)
                    ->subject('Delete Listing')
                    ->line('Deletion of a listing')
                    ->line('The listing '.$listing->title.' has been deleted .')
                    ->line('You can view deleted listing by clicking the button below.')
                    ->action('View deleted Listing', url('/'))
                    ->line('Thank you for using our application!');
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
            //
        ];
    }
}

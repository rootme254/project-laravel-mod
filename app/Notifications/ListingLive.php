<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ListingLive extends Notification implements ShouldQueue
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
        $this->user = $user;
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
                    ->subject('Your listing is live')
                    ->line('We are pleased to inform you that your listing '.$listing->title.' is now live on '.env(APP_NAME))
                    ->line('The listing went live at '.$listing->created_at.'.')
                    ->line('You can view your listing by clicking the button below.')
                    ->action('View listing', url('/'))
                    ->line('Thank you for using'.env(APP_NAME).'')
                    ->action('unsubscribe', route('unsubscribe',$user->id));
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

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBooking extends Notification
{
    use Queueable;
    public $user;
    public $booking;

    

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$booking)
    {
        $this->$user = $user;
        $this->booking = $booking;
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
                    ->subject('Added Booking')
                    ->line('We are pleased to inform you that the booking '.$booking.' was added')
                    ->line('You can view bookings by clicking the button below.')
                    ->action('View Booking', url('/'))
                    ->line('Thank you for using'.env(APP_NAME).'')
                    ->action('unsubscribe', route('unsubscribe',$user->id))
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

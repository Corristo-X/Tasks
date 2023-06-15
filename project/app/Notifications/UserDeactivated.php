<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Channels\DatabaseChannel;

class UserDeactivated extends Notification
{
    use Queueable;

      protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }


    public function via($notifiable)
    {
        //return ['mail']; // Używamy email jako kanału wysyłania notyfikacji
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Twoje konto zostało dezaktywowane: ' . $this->user->name)
            ->action('Skontaktuj się z administratorem', url('/contact'));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Twoje konto zostało dezaktywowane.'
        ];
    }
}


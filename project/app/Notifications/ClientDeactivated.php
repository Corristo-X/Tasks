<?php
// App\Notifications\ClientDeactivated.php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ClientDeactivated extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Twoje konto zostało dezaktywowane.',
        ];
    }
}

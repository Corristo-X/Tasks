<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserDeactivated extends Notification
{
    use Queueable;

    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->userId,
            'message' => 'Twoje konto zostało dezaktywowane.',
        ];
    }

    public function getUserId()
    {
        return $this->userId;
    }
}

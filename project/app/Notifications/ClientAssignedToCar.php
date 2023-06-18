<?php
namespace App\Notifications;
// App\Notifications\ClientAssignedToCar.php

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientAssignedToCar extends Notification
{
    use Queueable;

    private $car;

    public function __construct($car)
    {
        $this->car = $car;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'car_id' => $this->car->id,
            'car_model' => $this->car->model,
            'car_brand' => $this->car->brand,
            'car_year' => $this->car->year,
            'message' => 'Zostales przypisany do nowego pojazdu.',
        ];
    }
}

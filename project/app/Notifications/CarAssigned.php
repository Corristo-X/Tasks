<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CarAssigned extends Notification
{
    use Queueable;

    protected $car;
    public $user;

    public function __construct($car,$user)
    {
        $this->car = $car;
        $this->user = $user;
    }
    public function getCarId()
    {
        return $this->car->id;
    }
    public function getCar() {
        return $this->car;

    }

    public function via($notifiable)
    {
        return ['database']; // Używamy email jako kanału wysyłania notyfikacji
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Zostałeś przypisany do samochodu: ' . $this->car->name)
            ->action('Zobacz szczegóły', url('/cars/' . $this->car->id));
    }
    public function toArray($notifiable)
    {
        return [
            'car_id' => $this->car->id,
            'user_id' => $this->user->id,
            // możesz dodać więcej danych tutaj
        ];
    }
}


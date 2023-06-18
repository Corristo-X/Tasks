<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientAssignedToCar extends Notification
{
    use Queueable;

    private $car;
    private $clientId;

    public function __construct($car, $clientId)
    {
        $this->car = $car;
        $this->clientId = $clientId;
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
            'client_id' => $this->clientId,
            'message' => 'Zostales przypisany do nowego pojazdu.',
        ];
    }
    public function getCarId()
    {
        return $this->car->id;
    }

    public function getCarModel()
    {
        return $this->car->model;
    }

    public function getCarBrand()
    {
        return $this->car->brand;
    }

    public function getCarYear()
    {
        return $this->car->year;
    }

    public function getClientId()
    {
        return $this->clientId;
    }
}

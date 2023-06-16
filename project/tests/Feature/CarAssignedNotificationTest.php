<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Car;
use App\Notifications\CarAssigned;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CarAssignedNotificationTest extends TestCase
{
    public function test_car_assigned_notification()
    {


         // Notification::fake();

            $Client = Client::factory()->create();
            $car = Car::factory()->create();

            $Client->assignCar($car);

            Notification::assertSentTo(
                $Client,
                CarAssigned::class,
                function ($notification, $channels) use ($car) {
                    return $notification->getCar()->id === $car->id;
                }
            );


    }
}

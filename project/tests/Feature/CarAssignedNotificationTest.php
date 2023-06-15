<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Car;
use App\Notifications\CarAssigned;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CarAssignedNotificationTest extends TestCase
{
    public function test_car_assigned_notification()
    {


         // Notification::fake();

            $user = User::factory()->create();
            $car = Car::factory()->create();

            $user->assignCar($car);

            Notification::assertSentTo(
                $user,
                CarAssigned::class,
                function ($notification, $channels) use ($car) {
                    return $notification->getCar()->id === $car->id;
                }
            );


    }
}

<?php
// tests/Feature/NotificationTest.php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Notification;
use App\Models\Client;
use App\Models\Employee;

use App\Models\Car;
use App\Notifications\ClientAssignedToCar;
use App\Notifications\ClientDeactivated;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function testClientAssignedToCarNotification()
    {
        // Create a client
        Employee::factory()->create();
        $client = Client::factory()->create();

        // Create a car assigned to the client
        $car = Car::factory()->create([
            'client_id' => $client->id,
            'model' => 'Car Model',
            'brand' => 'Car Brand',
            'year' => 2023,
        ]);

        // Assign the client to the car
        $notification = new ClientAssignedToCar($car, $client->id);
        $notifiable = $client;

        // Assert that the notification is sent via the "database" channel
        $this->assertEquals(['database'], $notification->via($notifiable));

        // Assert the database notification data
        $expectedData = [
            'car_id' => $car->id,
            'car_model' => $car->model,
            'car_brand' => $car->brand,
            'car_year' => $car->year,
            'client_id' => $client->id,
            'message' => 'Zostales przypisany do nowego pojazdu.',
        ];
        $this->assertEquals($expectedData, $notification->toDatabase($notifiable));

        // Send the notification
        Notification::fake();
        $notifiable->notify($notification);

        // Assert that the notification was sent to the notifiable
        Notification::assertSentTo(
            $notifiable,
            ClientAssignedToCar::class,
            function ($notification, $channels, $notifiable) use ($expectedData) {
                // Assert the notification data
                $this->assertEquals($expectedData, $notification->toDatabase($notifiable));

                return true;
            }
        );
    }


    public function testClientDeactivatedNotification()
    {
        Notification::fake();
        Employee::factory()->create();
        $client = Client::factory()->create();

        // Dezaktywujesz klienta
        // $client->deactivate(); // zakładam, że masz metodę deaktywacji

        $client->notify(new ClientDeactivated());

        Notification::assertSentTo(
            [$client], ClientDeactivated::class
        );
    }
}

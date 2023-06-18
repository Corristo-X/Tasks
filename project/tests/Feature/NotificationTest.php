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
        Notification::fake();
        Employee::factory()->create();
        $client = Client::factory()->create();
       $car = Car::factory()->create();
      //$car = Car::factory()->create(['client_id' => $client->id]);
        // Przypisujesz samochód do klienta
        $client->cars()->save($car);

        $client->notify(new ClientAssignedToCar($car));

        Notification::assertSentTo(
            [$client], ClientAssignedToCar::class
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

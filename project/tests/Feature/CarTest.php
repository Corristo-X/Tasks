<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    protected function setUp(): void
{
    parent::setUp();

    // Tworzymy pracownika, aby był dostępny dla fabryki klienta
    Employee::factory()->create();
    Client::factory()->create();
    Car::factory()->create();

}

    public function test_create_car()
    {
        $client = Client::factory()->create();

        $carData = [
            'brand' => $this->faker->company,
            'model' => $this->faker->randomElement(['Corolla', 'Mustang', '3 Series', 'E Class', 'Civic']),
            'year' => $this->faker->year,
            'client_id' => $client->id,
            'currently_using' => $this->faker->boolean,
        ];

        $response = $this->post(route('cars.store'), $carData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('cars', $carData);
    }

    public function test_show_car()
{
    $client = Client::factory()->create();

    $car = Car::factory()->for($client)->create();

    $response = $this->get(route('cars.show', $car->id));

    $response->assertStatus(200);
    $response->assertViewHas('car');
}

    public function test_update_car()
    {
        $car = Car::factory()->create();
        $client = Client::factory()->create();

        $updatedData = [
            'brand' => $this->faker->company,
            'model' => $this->faker->randomElement(['Corolla', 'Mustang', '3 Series', 'E Class', 'Civic']),
            'year' => $this->faker->year,
            'client_id' => $client->id,
            'currently_using' => $this->faker->boolean,
        ];

        $response = $this->put(route('cars.update', $car->id), $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('cars', $updatedData);
    }

    public function test_delete_car()
    {
        $car = Car::factory()->create();

        $response = $this->delete(route('cars.destroy', $car->id));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }
}

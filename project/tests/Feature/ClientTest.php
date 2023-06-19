<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Car;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function setUp(): void
    {
        parent::setUp();
       Employee::factory()->count(1)->create();
       Client::factory()->count(1)->create();
    }
    public function test_create_client()
    {
        $employee = Employee::factory()->create();

        $clientData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'employee_id' => $employee->id,
        ];

        $response = $this->post(route('clients.store'), $clientData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', $clientData);
    }


    public function test_show_client()
    {
        // Tworzenie klienta
        $client = Client::factory()->create();

        // Wywołanie metody wyświetlającej klienta
        $response = $this->get(route('clients.show', $client->id));

        // Sprawdzenie odpowiedzi
        $response->assertStatus(200)
            ->assertJson([
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                // Dodaj pozostałe oczekiwane pola klienta
            ]);
    }


    public function test_update_client()
{
    // Tworzenie klienta
    $employee = Employee::factory()->create();
    $client = Client::factory()->create();
    $car = Car::factory()->create();
    $order = Order::factory()->create();
    $product = Product::factory()->create();

    // Generowanie danych do aktualizacji
    $updatedData = [
        'name' => $this->faker->name,
        'email' => $this->faker->unique()->safeEmail,
        'employee_id' => $employee->id,
        'cars' => [
            [
                'id' => $car->id, // ID istniejącego samochodu klienta
                'brand' => $this->faker->randomElement(['Toyota', 'Ford', 'BMW']),
                'model' => $this->faker->word,
                'year' => $this->faker->year,
                'currently_using' => $this->faker->boolean,
            ],
        ],
        'orders' => [
            [
                'id' => $order->id, // ID istniejącego zamówienia klienta
                'products' => [
                    [
                        'id' => $product->id, // ID istniejącego produktu w zamówieniu
                        'name' => $this->faker->word,
                        'price' => $this->faker->randomFloat(2, 1, 100),
                    ],
                ],
            ],
        ],
    ];

    // Wywołanie metody aktualizacji
    $response = $this->put(route('clients.update', $client->id), $updatedData);

    // Sprawdzenie odpowiedzi
    $response->assertStatus(200)
    ->assertJson(['message' => 'Klient został pomyślnie zaktualizowany']);


    // Sprawdzenie aktualizacji danych w bazie danych
    $this->assertDatabaseHas('clients', [
        'id' => $client->id,
        'name' => $updatedData['name'],
        'email' => $updatedData['email'],
        // Dodaj pozostałe pola, które chcesz sprawdzić
    ]);

    // Sprawdzenie aktualizacji samochodów
    foreach ($updatedData['cars'] as $carData) {
        $this->assertDatabaseHas('cars', [
            'id' => $carData['id'],
            'brand' => $carData['brand'],
            'model' => $carData['model'],
            'year' => $carData['year'],
            'currently_using' => $carData['currently_using'],
        ]);
    }

    // Sprawdzenie aktualizacji zamówień i produktów
    foreach ($updatedData['orders'] as $orderData) {
        $this->assertDatabaseHas('orders', [
            'id' => $orderData['id'],
            // Dodaj pozostałe pola, które chcesz sprawdzić
        ]);

        foreach ($orderData['products'] as $productData) {
            $this->assertDatabaseHas('products', [
                'id' => $productData['id'],
                'name' => $productData['name'],
                'price' => $productData['price'],
                // Dodaj pozostałe pola, które chcesz sprawdzić
            ]);
        }
    }
}




    public function test_delete_client()
    {
        $client = Client::factory()->create();

        $response = $this->delete(route('clients.destroy', $client->id));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}

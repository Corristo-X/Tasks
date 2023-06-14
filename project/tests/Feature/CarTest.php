<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Car;
use App\Models\User;

class CarTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    protected function setUp(): void
{
    parent::setUp();

    // Tworzymy dane testowe
    Car::factory()->count(10)->create();
}

    // Testowanie tworzenia samochodu
    public function test_create_car()
    {
        $user = User::factory()->create(); // tworzymy użytkownika do autoryzacji
        $carData = [
            'model' => $this->faker->randomElement(['Corolla', 'Mustang', '3 Series', 'E Class', 'Civic']),
            'year' => $this->faker->year(),
            'brand' => $this->faker->randomElement(['Toyota', 'Ford', 'BMW', 'Mercedes', 'Honda']),


        ];

        // Użytkownik musi być zalogowany, aby móc stworzyć samochód
        $response = $this->actingAs($user)->post(route('cars.store'), $carData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('cars', $carData);
    }

    // Testowanie wyświetlania samochodu
    public function test_show_car()
    {
        $car = Car::factory()->create();

        $response = $this->get(route('cars.show', $car->id));

        $response->assertStatus(200);
        $response->assertViewHas('car');
    }

    // Testowanie edycji samochodu
    public function test_edit_car()
    {
         // Utwórz użytkownika i samochód w bazie danych
    $user = User::factory()->create();
    $car = Car::factory()->create();

    // Dane samochodu do aktualizacji
    $carData = [
        'model' => 'New Model',
        'year' => 2022,
        'brand' => 'New Brand',
    ];

    // Użytkownik musi być zalogowany, aby móc edytować samochód
    $response = $this->actingAs($user)->put(route('cars.update', $car->id), $carData);

    // Sprawdź przekierowanie
    $response->assertStatus(302)->assertRedirect(route('cars.show', $car->id));

    // Sprawdź czy dane zostały zaktualizowane w bazie danych
    $this->assertDatabaseHas('cars', $carData);
    }

    // Testowanie usuwania samochodu
    public function test_delete_car()
    {
        $user = User::factory()->create();
    $car = Car::factory()->create();

    $response = $this->actingAs($user)->delete(route('cars.destroy', $car->id));

    $response->assertStatus(302); // Zmiana oczekiwanego statusu na 302
    $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }
}

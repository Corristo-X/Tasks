<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $clientIds = Client::pluck('id')->toArray();
        $currentlyUsing = $this->faker->randomElement([true, false]);

        return [
            'model' => $this->faker->randomElement(['Corolla', 'Mustang', '3 Series', 'E Class', 'Civic']),
            'year' => $this->faker->year(),
            'brand' => $this->faker->randomElement(['Toyota', 'Ford', 'BMW', 'Mercedes', 'Honda']),
            'client_id' => $this->faker->randomElement($clientIds),
            'currently_using' => $currentlyUsing,
        ];
    }
}

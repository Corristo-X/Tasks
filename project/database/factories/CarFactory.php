<?php

namespace Database\Factories;

use App\Models\Car;
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
        return [
            'model' => $this->faker->randomElement(['Corolla', 'Mustang', '3 Series', 'E Class', 'Civic']),
            'year' => $this->faker->year(),
            'brand' => $this->faker->randomElement(['Toyota', 'Ford', 'BMW', 'Mercedes', 'Honda']),
        ];
    }
    public function configure()
{
    return $this->afterCreating(function (Car $car) {
        $car->users()->attach(
            User::all()->random()->id,
            ['currently_using' => $this->faker->boolean()]
        );
    });
}
}

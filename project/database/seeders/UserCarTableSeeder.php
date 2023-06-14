<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\User;

class UserCarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $cars = Car::all();

        // for each user, attach random cars
        foreach ($users as $user) {
            $user->cars()->attach(
                $cars->random(rand(1, 3))->pluck('id')->toArray(),
                ['currently_using' => rand(0, 1)]
            );
        }
    }
}

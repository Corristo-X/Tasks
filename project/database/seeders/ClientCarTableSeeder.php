<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\Client;

class ClientCarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();
        $cars = Car::all();

        // for each client, attach random cars
        foreach ($clients as $client) {
            $client->cars()->attach(
                $cars->random(rand(1, 3))->pluck('id')->toArray(),
                ['currently_using' => rand(0, 1)]
            );
        }
    }
}

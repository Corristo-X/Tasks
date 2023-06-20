<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        {
            for ($i = 0; $i < 100; $i++) {
                $client = Client::factory()->create();

                $email = Str::random(10) . '@example.com';

                $user = User::create([
                    'name' => $client->name,
                    'email' => $email,
                    'password' => Hash::make('password'),
                ]);
                $employee = Employee::factory()->create();
                Client::create([
                    'name' => $client->name,
                    'email' => $email,
                    'employee_id' => $employee->id,// Wygeneruj losowe ID pracownika
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use OrderProductTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(EmployeesTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        //
        /*
        $this->call([
            // inny seeder
            // inny seeder
            OrderProductTableSeeder::class,
        ]);
        */
        $this->call(CarsTableSeeder::class);
        $this->call(UserTableSeeder::class);

       // $this->call(OrderProductTableSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

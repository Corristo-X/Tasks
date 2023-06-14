<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



use App\Models\Employee;

class EmployeesTableSeeder extends Seeder
{
    public function run()
    {
        Employee::factory()->count(50)->create();
    }
}

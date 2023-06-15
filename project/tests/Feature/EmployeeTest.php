<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_employee()
    {
        $employeeData = [
            'name' => $this->faker->name,
           // 'email' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->post(route('employees.store'), $employeeData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('employees', $employeeData);
    }

    public function test_show_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employees.show', $employee->id));

        $response->assertStatus(200);
        $response->assertViewHas('employee');
    }

    public function test_update_employee()
    {
        $employee = Employee::factory()->create();
        $updatedData = [
            'name' => $this->faker->name,
           // 'email' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->put(route('employees.update', $employee->id), $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('employees', $updatedData);
    }

    public function test_delete_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->delete(route('employees.destroy', $employee->id));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }
}

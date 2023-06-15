<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Employee;
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
        $client = Client::factory()->create();

        $response = $this->get(route('clients.show', $client->id));

        $response->assertStatus(200);
        $response->assertViewHas('client');
    }

    public function test_update_client()
    {
        $client = Client::factory()->create();
        $updatedData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,

        ];

        $response = $this->put(route('clients.update', $client->id), $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', $updatedData);
    }

    public function test_delete_client()
    {
        $client = Client::factory()->create();

        $response = $this->delete(route('clients.destroy', $client->id));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}

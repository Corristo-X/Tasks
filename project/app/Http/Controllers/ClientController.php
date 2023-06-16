<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Order;
use Illuminate\Http\Request;

class ClientController extends Controller
{


    public function index()
    {
        try {
            $clients = Client::all();
            return response()->json($clients);
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function store(Request $request)
    {
        // Walidacja danych wejściowych
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            // inne pola walidacji
        ]);

        // Przypisanie pracownika do klienta
        $employee = Employee::whereDoesntHave('clients')->first();

        if (!$employee) {
            return response()->json(['error' => 'Brak dostępnych pracowników'], 400);
        }

        // Tworzenie nowego klienta w bazie danych
        $client = new Client($validatedData);
        $client->employee_id = $employee->id;
        $client->save();

        return response()->json($client, 201);
    }



        /*
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'employee_id' => 'required|exists:employees,id',
            // możesz dodać tutaj dodatkowe reguły walidacji, jeżeli są potrzebne
        ]);

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->employee_id = $request->employee_id;  // Przypisujemy pracownika do klienta
        $client->save();

        return response()->json(['message' => 'Client created successfully'], 201);
        */

    public function show($id)
    {
        $client = Client::with('employee', 'orders.products','cars')->find($id);

        if ($client) {
            // obliczanie totalSpent dla klienta
            $client->totalSpent = $client->orders->reduce(function ($carry, $order) {
                return $carry + $order->totalCost;
            }, 0);

            return response()->json($client);
        }

        return response()->json(['error' => 'Client not found'], 404);
    }


public function update(Request $request, Client $client)
{
    // Walidacja danych żądania (jeśli jest potrzebna)

    // Aktualizacja danych klienta
    $client->update($request->all());

    return response()->json(['message' => 'Client updated successfully'], 200);
}
public function destroy(Client $client)
{
    $client->delete();

    return response()->json(['message' => 'Client deleted successfully'], 200);
}




}
?>

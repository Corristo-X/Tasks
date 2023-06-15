<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Order;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /*
    public function show($clientId)
    {
        $client = Client::with(['employee', 'orders'])->find($clientId);

        // Wypisz informacje na temat klienta
        echo 'Imię klienta: ' . $client->name;
        echo 'Adres e-mail klienta: ' . $client->email;

        // Informacje na temat pracownika przypisanego do klienta
        $employee = $client->employee;
        echo 'Pracownik przypisany do klienta: ' . $employee->name;

        // Zamówienia
        $orders = $client->orders;

        echo 'Ostatnie zamówienia klienta: ';
        foreach($orders as $order) {
            echo 'Id zamówienia: ' . $order->id;
            echo 'Data zamówienia: ' . $order->created_at;
            // Wypiszemy tutaj również informacje na temat produktów w zamówieniu
            foreach($order->products as $product) {
                echo 'Nazwa produktu: ' . $product->name;
                echo 'Cena produktu: ' . $product->price;
            }
        }
    }
    */
    public function store(Request $request)
    {
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
    }
    public function show(Client $client)
{
    return view('clients.show', ['client' => $client]);
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

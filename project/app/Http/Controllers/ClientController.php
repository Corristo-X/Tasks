<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Order;

class ClientController extends Controller
{
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
}
?>

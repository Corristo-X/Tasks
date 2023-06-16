<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Car;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    /*
        public function index()
        {
            try {
                $clients = Client::paginate(10);
                return response()->json($clients);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    */
    public function index(Request $request)
    {
        try {
            $query = Client::query();

            // Filtracja
            $filterField = $request->query('filter_field');
            $filterValue = $request->query('filter_value');

            if ($filterField && $filterValue) {
                $query->where($filterField, 'like', '%' . $filterValue . '%');
            }

            // Sortowanie
            $sortField = $request->query('sort', 'name');
            $sortDirection = $request->query('direction', 'asc');
            $query->orderBy($sortField, $sortDirection);

            $clients = $query->paginate(10);
            return response()->json($clients);
        } catch (\Exception $e) {
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


    public function show($id)
    {
        $client = Client::with('employee', 'orders.products', 'cars')->find($id);

        if ($client) {
            // obliczanie totalSpent dla klienta
            $client->totalSpent = $client->orders->reduce(function ($carry, $order) {
                return $carry + $order->totalCost;
            }, 0);

            return response()->json($client);
        }

        return response()->json(['error' => 'Client not found'], 404);
    }


    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['error' => 'Klient nie został znaleziony'], 404);
        }

        // walidacja danych z żądania
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'employee_id' => 'required|integer|exists:employees,id',
            // upewniamy się, że pracownik istnieje
            'cars.*.brand' => 'required|string',
            'cars.*.model' => 'required|string',
            'cars.*.year' => 'required|date_format:Y',
            'orders.*.products.*.name' => 'required|string',
            'orders.*.products.*.price' => 'required|numeric',
            'cars.*.currently_using' => 'required|boolean',

        ]);
        // aktualizacja samochodów i ich relacji z klientem
        foreach ($request->input('cars') as $carData) {
            $car = Car::find($carData['id']);
            if ($car) {
                // tworzenie kopii danych do zaktualizowania samochodu
                $updateCarData = $carData;
                // usunięcie 'pivot' z danych samochodu
                unset($updateCarData['pivot']);

                // aktualizacja danych samochodu
                $car->update($updateCarData);
                // dodanie aktualizacji 'currently_using'
                $updateCarData['currently_using'] = $carData['currently_using'];
                // aktualizacja relacji z klientem
                if (isset($carData['pivot'])) {
                    $pivotData = $carData['pivot'];

                    // konwersja dat do prawidłowego formatu
                    if (isset($pivotData['created_at'])) {
                        $pivotData['created_at'] = Carbon::parse($pivotData['created_at']);
                    }

                    if (isset($pivotData['updated_at'])) {
                        $pivotData['updated_at'] = Carbon::now();
                    }

                    $client->cars()->updateExistingPivot($car->id, $pivotData);
                }

            }
        }



        // aktualizacja zamówień i produktów
        foreach ($request->input('orders') as $orderData) {
            $order = Order::find($orderData['id']);
            if ($order) {
                $order->update($orderData);

                foreach ($orderData['products'] as $productData) {
                    $product = Product::find($productData['id']);
                    if ($product) {
                        $product->update($productData);
                    }
                }
            }
        }

        // aktualizacja danych klienta
        $client->update($validatedData);

        return response()->json(['message' => 'Klient został pomyślnie zaktualizowany'], 200);
    }

    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['error' => 'Klient nie został znaleziony'], 404);
        }

        foreach ($client->orders as $order) {
            $order->delete();
        }
        $client->delete();
        return response()->json(['message' => 'Klient został pomyślnie usunięty'], 200);
    }





}
?>

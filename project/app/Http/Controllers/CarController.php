<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Client;
use App\Notifications\ClientAssignedToCar;


class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return response()->json($cars);
    }
    public function getAllCars()
    {
        try {
            $cars = Car::all();
            return response()->json($cars);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required',
            'year' => 'required|integer',
            'brand' => 'required',
            'client_id' => 'required|exists:clients,id',
            'currently_using' => 'required|boolean',
        ]);

        $car = Car::create($validatedData);
        $clientId = $validatedData['client_id']; // Pobierz wartość client_id z validatedData
        $carId = $car->id; // Pobierz ID utworzonego samochodu

        $client = Client::find($clientId);
        $car = Car::find($carId);

        $client->notify(new ClientAssignedToCar($car,$clientId));

        return response()->json($car, 201);
    }

    public function update(Request $request, Car $car)
    {
        $validatedData = $request->validate([
            'model' => 'required',
            'year' => 'required|integer',
            'brand' => 'required',
            'client_id' => 'required|exists:clients,id',
            'currently_using' => 'required|boolean',
        ]);
        $clientId = $validatedData['client_id']; // Pobierz wartość client_id z validatedData
        $carId = $car->id; // Pobierz ID utworzonego samochodu

        $client = Client::find($clientId);
        $car = Car::find($carId);

        $client->notify(new ClientAssignedToCar($car,$clientId));
        $car->update($validatedData);
        return response()->json($car, 200);
    }
    public function show($id)
{
    $car = Car::find($id);

    if (!$car) {
        abort(404, 'Car not found');
    }

    return view('cars.show', ['car' => $car]);
}


    public function destroy(Car $car)
    {
        $car->delete();
        return response()->json(null, 200);
    }


}

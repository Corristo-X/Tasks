<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Client;
use App\Notifications\CarAssigned;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
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

    public function assignCar(Request $request, $carId, $clientId)
    {
        $car = Car::find($carId);
        $client = Client::find($clientId);

        if (!$car || !$client) {
            return redirect()->route('cars.index')->withErrors(['error' => 'Car or Client not found.']);
        }

        $client->car_id = $car->id;
        $client->save();

        $client->notify(new CarAssigned($car));

        return redirect()->route('cars.index');
    }
}

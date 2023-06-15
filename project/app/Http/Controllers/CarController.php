<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use App\Notifications\CarAssigned;
class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Car::create($request->all());
       // return redirect()->route('cars.index');
       $car = Car::create($request->all());
       return response()->json($car, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $Car)
    {
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $car->update($request->all());
        return redirect()->route('cars.show', $car->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index');
    }
    public function assignCar(Request $request, $carId, $userId)
    {
        // Wyszukaj samochód i użytkownika
        $car = Car::find($carId);
        $user = User::find($userId);

        // Przypisz samochód do użytkownika
        $user->car_id = $car->id;
        $user->save();

        // Wysyłamy notyfikację
        $user->notify(new CarAssigned($car));

        // Przekierowujemy do jakiejś strony
        return redirect()->route('cars.index');
    }


}

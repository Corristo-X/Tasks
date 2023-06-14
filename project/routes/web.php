<?php
/*
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
*/
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


use App\Models\User;
use App\Models\Car;

use App\Http\Controllers\ClientController;

Route::get('/clients/{client}', [ClientController::class, 'show']);
Route::get('/test', function () {

    /*
    $user = User::find(1);

if ($user) {
    $car = Car::find(1);
    if ($car) {
        $user->cars()->attach($car->id);
    } else {
        echo "Samochód o podanym ID nie istnieje.";
    }
} else {
    echo "Użytkownik o podanym ID nie istnieje.";
}
*/

    $user = User::find(2);
    $car = Car::find(2);

    // Przypisz użytkownika do samochodu
    $user->cars()->attach($car->id);

    // Sprawdź, czy użytkownik korzysta z samochodu
    if ($user->cars()->where('car_id', $car->id)->first()->pivot->currently_using) {
        echo "Użytkownik obecnie korzysta z samochodu";
    } else {
        echo "Użytkownik nie korzysta obecnie z samochodu";
    }

    // Ustaw, że użytkownik obecnie korzysta z samochodu
    $user->cars()->updateExistingPivot($car->id, ['currently_using' => true]);

});


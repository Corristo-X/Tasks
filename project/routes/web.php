<?php


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\AuthController;


Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clients/all', [ClientController::class, 'getAllClients'])->name('clients.All');
Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show.client');


Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{id}', [CarController::class, 'show'])->name('cars.show');
Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
Route::get('/cars/all', [CarController::class, 'getAllCars']);


Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

Route::get('/notifications/{userId}', [NotificationsController::class, 'index'])->name('notifications.index');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::patch('/users/{user}/deactivate', [UserController::class, 'deactivate']);
Route::patch('/users/{user}/activate', [UserController::class, 'activate']);
Route::get('/users', [UserController::class, 'index']);

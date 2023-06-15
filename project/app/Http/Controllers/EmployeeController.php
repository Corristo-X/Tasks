<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\UserDeactivated;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $employee = Employee::create($request->all());

        return response()->json(['message' => 'Employee created successfully'], 201);
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->update($request->all());

        return response()->json(['message' => 'Employee updated successfully'], 200);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully'], 200);
    }
    public function deactivateUser($userId)
    {
        // Wyszukaj użytkownika
        $user = User::find($userId);

        // Dezaktywuj użytkownika
        $user->active = false;
        $user->save();

        // Wysyłamy notyfikację
        $user->notify(new UserDeactivated());

        // Przekierowujemy do jakiejś strony
        return redirect()->route('users.index');
    }

}

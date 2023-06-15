<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

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
}

<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function store(Request $request)
{
    $data = $request->validate([
        'owner_id' => 'required',
        'name'=> 'required|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
]);

    $employee = Employee::create($data);

    return response()->json(['message' => 'Employee created successfully', 'data' => $employee], 201);
}

public function show($id)
{
    $employee = Employee::findOrFail($id);

    return response()->json(['data' => $employee]);
}

public function update(Request $request, $id)
{
    $employee = Employee::findOrFail($id);

    $data = $request->validate([
        'owner_id' => 'required',
        'name' => 'required',
        'email' => 'required|unique:employees,email,' . $id,
        'password' => 'required',
    ]);

    $employee->update($data);

    return response()->json(['message' => 'Employee updated successfully', 'data' => $employee]);
}

public function destroy($id)
{
    $employee = Employee::findOrFail($id);
    $employee->delete();

    return response()->json(['message' => 'Employee deleted successfully']);
}

}

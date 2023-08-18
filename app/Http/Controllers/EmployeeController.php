<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json(['data' => $employees]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'owner_username' => 'required|exists:owners,username', // Update to use owner_username
            'name' => 'required|string|max:255',
            'username' => 'required|unique:employees', // Add username validation
            'email' => 'required|email|unique:employees',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']); // Hash the password
        $employee = Employee::create($data);

        return response()->json(['message' => 'Employee created successfully', 'data' => $employee], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json(['data' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'owner_username' => 'sometimes|exists:owners,username', // Update to use owner_username
            'name' => 'sometimes|string|max:255',
            'username' => 'sometimes|unique:employees,username,' . $id, // Add username validation
            'email' => 'sometimes|email|unique:employees,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $employee = Employee::findOrFail($id);

        if ($request->has('owner_username')) {
            $employee->owner_username = $request->input('owner_username');
        }
        if ($request->has('name')) {
            $employee->name = $request->input('name');
        }
        if ($request->has('username')) {
            $employee->username = $request->input('username');
        }
        if ($request->has('email')) {
            $employee->email = $request->input('email');
        }
        if ($request->has('password')) {
            $employee->password = bcrypt($request->input('password'));
        }

        $employee->save();

        return response()->json(['message' => 'Employee updated successfully', 'data' => $employee]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}

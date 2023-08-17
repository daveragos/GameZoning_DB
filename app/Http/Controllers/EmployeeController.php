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
            'owner_id' => 'required|exists:owners,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|min:6',
        ]);

        $employee = Employee::create([
            'owner_id' => $request->input('owner_id'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Hash the password
        ]);

        return response()->json(['message' => 'Employee created successfully', 'data' => $employee], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::findorFail($id);
        return response()->json(['data' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'owner_id' => 'sometimes|exists:owners,id',
            'name' => 'sometimes|string|max:255', // Validation rule for name
            'email' => 'sometimes|email|unique:employees,email,' . $id,
            'password' => 'nullable|min:6', // Allow password to be updated
        ]);

        $employee = Employee::findOrFail($id);


        if ($request->has('owner_id')) {
            $employee->email = $request->input('owner_id');
        }
        if ($request->has('name')) {
            $employee->name = $request->input('name');
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

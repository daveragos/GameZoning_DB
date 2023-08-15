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
        $data = $request->validate([
            'owner_id' => 'required|exists:owners,id', // Ensure owner_id exists in owners table
            'name' => 'required|min:3',
            'email' => 'required|email|unique:employees,email', // Check uniqueness in employees table
            'password' => 'required|min:6',
        ]);

        // Create and store the employee
        // $employee = Employee::create($data);

        return response()->json(['message' => 'Employee created successfully', 'data' => $data], 201);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

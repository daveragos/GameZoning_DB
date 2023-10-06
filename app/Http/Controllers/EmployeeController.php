<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Owner;

class EmployeeController extends Controller
{



    public function getByOwnerUsername($ownerUsername)
{
    // Retrieve the owner's ID using their username
    $owner = Owner::where('username', $ownerUsername)->first();

    if($owner){
        
    }
    // Retrieve the employees associated with the owner's ID
    $employees = Employee::where('owner_username', $owner)->get();

    // Return the employees as a JSON response
    return response()->json(['data' => $employees]);
}
    //tokening method
        //tokening method

        public function generateToken($user) {
            return $user->createToken('EmployeeToken')->plainTextToken;
        }

        //employee register method
        public function register(Request $request) {
            $data =        $request->validate([
                'owner_username' => 'required|exists:owners,username', // Update to use owner_username
                'name' => 'required|string|max:255',
                'username' => 'required|unique:employees', // Add username validation
                'email' => 'required|email|unique:employees',
                'password' => 'required|min:6',
            ]);
            $data['password'] = Hash::make($data['password']); // Hash the password

            $employee = Employee::create($data);
            $token = $this->generateToken($employee);

            return response()->json(['message' => 'Employee registered successfully', 'user' => $employee, 'token' => $token, 'label' => 'employee'], 200);
        }
        //employee login method
        public function login(Request $request) {
            $email = $request->input('email');
            $password = $request->input('password');

            // Check if an employee with the provided email exists
            $employee = Employee::where('email', $email)->first();

            if ($employee && Hash::check($password, $employee->password)) {
                // Authentication successful
                $token = $this->generateToken($employee);

                return response()->json(['message' => 'Login successful', 'user' => $employee, 'token' => $token, 'label' => 'employee']);
            } else {
                // Invalid credentials
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        }

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

        return response()->json(['message' => 'Employee created successfully', 'data' => $employee], 200);
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

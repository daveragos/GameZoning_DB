<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    //tokening method

    public function generateToken($user) {
        return $user->createToken('OwnerToken')->plainTextToken;
    }

    //owner register method
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:owners',
            'email' => 'required|email|unique:owners',
            'password' => 'required|min:6',
        ]);

        $data['password'] = Hash::make($data['password']); // Hash the password

        $owner = Owner::create($data);
        $token = $this->generateToken($owner);

        return response()->json(['message' => 'Owner registered successfully', 'user' => $owner, 'token' => $token], 201);
    }
    //owner login method

    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');

        // Check if an owner with the provided email exists
        $owner = Owner::where('email', $email)->first();

        if ($owner && Hash::check($password, $owner->password)) {
            // Authentication successful
            $token = $this->generateToken($owner);

            return response()->json(['message' => 'Login successful', 'user' => $owner, 'token' => $token]);
        } else {
            // Invalid credentials
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function index()
    {
        $owners = Owner::all();
        return response()->json(['data' => $owners]);
    }

    public function show($id)
    {
        $owner = Owner::findOrFail($id);
        return response()->json(['data' => $owner]);
    }


//registering owner
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:owners', // Add username validation
            'email' => 'required|email|unique:owners',
            'password' => 'required|min:6',
        ]);

        $data['password'] = bcrypt($data['password']); // Hash the password

        $owner = Owner::create($data);
        return response()->json(['message' => 'Owner created successfully', 'data' => $owner], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'username' => 'sometimes|unique:owners,username,' . $id, // Add username validation
            'email' => 'sometimes|email|unique:owners,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $owner = Owner::findOrFail($id);

        if ($request->has('name')) {
            $owner->name = $request->input('name');
        }

        if ($request->has('username')) {
            $owner->username = $request->input('username');
        }

        if ($request->has('email')) {
            $owner->email = $request->input('email');
        }

        if ($request->has('password')) {
            $owner->password = bcrypt($request->input('password'));
        }

        $owner->save();

        return response()->json(['message' => 'Owner updated successfully', 'data' => $owner]);
    }

    public function destroy($id)
    {
        $owner = Owner::findOrFail($id);
        $owner->delete();
        return response()->json(['message' => 'Owner deleted successfully']);
    }
}

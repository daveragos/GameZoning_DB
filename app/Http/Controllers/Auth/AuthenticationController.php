<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function registerOwner(RegisterRequest $request) {
        $request ->validated();

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make( $request->name),

        ];

        $user = Owner::create([
            'name' => $userData['name'],
            'username' => $userData['username'],
            'email' => $userData['email'],
            'password' => $userData['password'],
        ]
        );
        $token = $user->createToken('GameZoning_DB')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function loginOwner(LoginRequest $request) {
        $request ->validated();

        $user = Owner::where('username', $request->username)->first();
        dd($user);
        if(!$user || !Hash::check($request->password,$user->password)) {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        $token = $user->createToken('GameZoning_DB')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }
    public function registerEmployee(RegisterRequest $request) {
        $request ->validated();

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make( $request->name),

        ];

        $user = Owner::create([
            'name' => $userData['name'],
            'username' => $userData['username'],
            'email' => $userData['email'],
            'password' => $userData['password'],
        ]
        );
        $token = $user->createToken('GameZoning_DB')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function loginEmployee(LoginRequest $request) {
        $request ->validated();

        $user = Owner::where('username', $request->username)->first();
        dd($user);
        if(!$user || !Hash::check($request->password,$user->password)) {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        $token = $user->createToken('GameZoning_DB')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }
}

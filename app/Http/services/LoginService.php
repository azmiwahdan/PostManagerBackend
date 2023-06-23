<?php

namespace App\Http\services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class LoginService
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required:unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'successfully registered', 'user' => new UserResource($user), 'token' => $token], 201);

    }

    public function login(Request $request)
    {
        $validatedData = $request->validate(
            [
                'email' => 'required|string',
                'password' => 'required|string'
            ]);

        $user = User::where('email', $validatedData['email'])->first();
        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'user' => new UserResource($user),
            'token' => $token
        ];

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function retrieveAuthenticatedUser()
    {
        $user = Auth::user();
        if (!Auth::check()) {
            return response()->json(['message' => 'unauthenticated user'], 401);
        }
        return $user;

    }

}

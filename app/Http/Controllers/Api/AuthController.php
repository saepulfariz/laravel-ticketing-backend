<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Google_Client;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        // {
        //     "name" :"admin",
        //     "email" :"admin@gmail.com",
        //     "password" : "123",
        //     "password_confirmation" : "123"
        //   }

        // create users
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user  = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials',
            ], 401);
        }


        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => 'success',
            'message' => 'User Logged in successfully',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 200);
    }

    public function loginGoogle(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        $idToken = $request->id_token;

        $client = new Google_Client(['client_id' => env("GOOGLE_CLIENT_ID")]);
        $payload = $client->verifyIdToken($idToken);

        if (!$payload) {
            $user  = User::where('email', $payload['email'])->first();
            $token = $user->createToken('auth_token')->plainTextToken;
            if ($user) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Logged in successfully',
                    'data' => [
                        'user' => $user,
                        'token' => $token
                    ]
                ], 200);
            } else {
                // create users
                $user = User::create([
                    'name' => $payload['name'],
                    'email' => $payload['email'],
                    'password' => Hash::make($payload['sub'])
                ]);

                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => 'success',
                    'message' => 'User created successfully',
                    'data' => [
                        'user' => $user,
                        'token' => $token
                    ]
                ], 201);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid id token',
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        // Authorization Bearer token

        return response()->json([
            'status' => 'success',
            'message' => 'User Logged out successfully',
        ], 200);
    }
}

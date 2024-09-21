<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    // Register
    public function register(RegisterUserRequest $request)
    {
        try {
            $validated_data = $request->validated();

            $user = User::create([
                'name' => $validated_data['name'],
                'email' => $validated_data['email'],
                'password' => Hash::make($validated_data['password']),
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ];

            return response()->json([
                'status' => true,
                'message' => 'Create Token Success.',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Create Token Failed. Message: ' . $e->getMessage(),
                'data' => null
            ]);
        }
    }

    // Login
    public function login(LoginUserRequest $request)
    {
        try {
            $validated_data = $request->validated();

            $creds = request(['email', 'password']);

            if (!Auth::attempt($creds)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Authentication Failed!',
                    'data' => null
                ]);
            }

            $user = User::where('email', $validated_data['email'])->first();

            if (!Hash::check($validated_data['password'], $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $token = $user->createToken('authToken')->plainTextToken;

            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ];

            return response()->json([
                'status' => true,
                'message' => 'Authenticated.',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Authentication Failed!',
                'data' => null
            ]);
        }
    }

    // Logout
    public function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();

        return response()->noContent();
    }
}

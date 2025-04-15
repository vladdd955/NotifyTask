<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiLoginLogoutController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                Auth::login($user, true);

                $token = $user->createToken('API Token')->plainTextToken;
                return response()->json(['message' => 'Successfully logged in', 'token' => $token]);
            }

            return response()->json(['code'=> 400, 'message' => 'Invalid credentials']);
        } catch (\Exception $e) {
            Log::debug('Login request error', [$e->getMessage()]);
            return response()->json(['error' => 'Error login:', $e->getMessage()], 400);
        }
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();
        return response()->json(['code' => 200, 'message' => 'Successfully logged out']);
    }

}

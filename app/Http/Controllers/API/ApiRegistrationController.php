<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;

class ApiRegistrationController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];

            $user = User::create($userData);
            event(new Registered($user));

            Auth::login($user);
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json(['message' => 'Successfully registered', 'token' => $token]);
        } catch (\Exception $e) {
            Log::debug('register request error', [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}

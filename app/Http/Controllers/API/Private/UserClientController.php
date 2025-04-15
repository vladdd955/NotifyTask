<?php

namespace App\Http\Controllers\API\Private;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserClientController extends Controller
{
    public function getUsersList(): JsonResponse
    {
        try {
            $users = User::all();

            return response()->json(['message' => 'Success', 'User' => $users]);
        } catch (\Exception $e) {
            Log::debug('User request error:', [$e->getMessage()]);
            return response()->json(['error' => 'User request error: ', [$e->getMessage()]], 400);
        }
    }


}

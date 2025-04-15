<?php

namespace App\Http\Controllers\API\Private;

use App\Http\Controllers\Controller;
use App\Services\NotificationQueueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationQueueController extends Controller
{
    public function process(Request $request): JsonResponse
    {
        $request->validate([
            'channel' => 'required|string|in:sms,email',
        ]);

        $results = NotificationQueueService::queueProcess($request->channel);

        return response()->json([
            'message' => 'Queue processed',
            'results' => $results,
        ]);
    }

}

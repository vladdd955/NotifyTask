<?php

namespace App\Http\Controllers\API\Private;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService) {}

    public function create(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|string|exists:users,email',
                'channel' => 'required|string',
                'message' => 'required|string',
            ]);

            $notification = $this->notificationService->createNotify($request->post());

            return response()->json(['message' => 'Success', 'Notification: ' => $notification]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error', 'Notification: ' => $e->getMessage()]);

        }
    }

    public function createWithTemplateId(Request $request): JsonResponse
    {
        try {
            $templateSata = $request->validate([
                'email' => 'required|string|exists:users,email',
                'template_id' => 'required|int',
            ]);

            $notification = $this->notificationService->createFromTemplate($templateSata);

            return response()->json(['message' => 'Success', 'Notification with template_id: ' => $notification]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error', 'Notification with template_id: ' => $e->getMessage()]);

        }
    }

    public function getUserNotify(Request $request): JsonResponse
    {
        try {
            $email = $request->validate([
                'email' => 'required|string|exists:users,email',
            ]);

            $notification = $this->notificationService->userNotify($email);

            return response()->json(['message' => 'Success', 'User Notify' => $notification]);
        } catch (\Exception $e) {
            Log::debug('User notify request error:', [$e->getMessage()]);
            return response()->json(['error' => 'User notify request error: ', [$e->getMessage()]], 400);
        }
    }

    public function getAllNotify(): JsonResponse
    {
        try {
            $notifications = $this->notificationService->getAllNotify();

            return response()->json(['message' => 'Success', 'User Notify' => $notifications]);
        } catch (\Exception $e) {
            Log::debug('User notify request error:', [$e->getMessage()]);
            return response()->json(['error' => 'User notify request error: ', [$e->getMessage()]], 400);
        }
    }

}

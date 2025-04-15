<?php

namespace App\Http\Controllers\API\Private;

use App\Http\Controllers\Controller;
use App\Services\TemplateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TemplateController extends Controller
{
    public function __construct(protected TemplateService $templateService) {}

    public function create(Request $request): JsonResponse
    {
        try {
            $templateData = $request->validate([
                'name' => 'required|string',
                'channel' => 'required|string|in:sms,email',
                'message' => 'required|string',
            ]);

            $template = $this->templateService->createTemplate($templateData);
            return response()->json(['message' => 'Success', 'Template was created' => $template]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Template creating request error: ', [$e->getMessage()]], 400);
        }
    }

    public function getTemplates(): JsonResponse
    {
        try {
            $templates = $this->templateService->allTemplate();

            return response()->json(['message' => 'Success', 'Template was created' => $templates]);
        } catch (\Exception $e) {
            Log::debug('User notify request error:', [$e->getMessage()]);
            return response()->json(['error' => 'Template creating request error: ', [$e->getMessage()]], 400);
        }
    }

}

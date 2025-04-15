<?php

use App\Http\Controllers\API\ApiLoginLogoutController;
use App\Http\Controllers\API\ApiRegistrationController;
use App\Http\Controllers\API\Private\NotificationController;
use App\Http\Controllers\API\Private\NotificationQueueController;
use App\Http\Controllers\API\Private\TemplateController;
use App\Http\Controllers\API\Private\UserClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [ApiRegistrationController::class, 'register']);
Route::post('/login', [ApiLoginLogoutController::class, 'login']);



Route::middleware('auth:sanctum')->get('/logout', [ApiLoginLogoutController::class, 'logout']);


Route::middleware('auth:sanctum')->post('/users', [UserClientController::class, 'getUsersList']);

Route::middleware('auth:sanctum')->post('/user/notify', [NotificationController::class, 'getUserNotify']);
Route::middleware('auth:sanctum')->get('/user/all/notify', [NotificationController::class, 'getAllNotify']);
Route::middleware('auth:sanctum')->post('/notify/create', [NotificationController::class, 'create']);
Route::middleware('auth:sanctum')->post('/notify/create/id', [NotificationController::class, 'createWithTemplateId']);

Route::middleware('auth:sanctum')->post('/template/create', [TemplateController::class, 'create']);
Route::middleware('auth:sanctum')->get('/templates/all', [TemplateController::class, 'getTemplates']);


Route::middleware('auth:sanctum')->post('/notify/process', [NotificationQueueController::class, 'process']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



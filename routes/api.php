<?php

use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\SeedController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;

function isValidToken($request)
{
    $authHeader = $request->header('Authorization');

    if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
        return false;
    }

    $token = str_replace('Bearer ', '', $authHeader);

    return PersonalAccessToken::findToken($token) !== null;
}

Route::get('/destinations', function (\Illuminate\Http\Request $request) {
    if (!isValidToken($request)) {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    return app(DestinationController::class)->index($request);
});

Route::post('/seed', function (\Illuminate\Http\Request $request) {
    if (!isValidToken($request)) {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    return app(SeedController::class)->store($request);
});
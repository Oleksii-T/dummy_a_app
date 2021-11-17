<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\PaypalController;

Route::name('api.')->prefix('v1')->group(function () {
    Route::middleware('auth:api')->group(function() {
        Route::post('upload', [UploadController::class, 'store']);
        Route::apiResource('stripe', StripeController::class)->only('store');
        Route::apiResource('paypal', PaypalController::class)->only('store');
        Route::apiResource('subscription', SubscriptionController::class)->only('destroy');
    });
});

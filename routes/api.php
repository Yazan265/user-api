<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group(['middleware'  => 'api', 'prefix' => 'auth'], function ($router) {

    // مسارات عامة
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // مسارات تحتاج مصادقة (Auth Token)
    Route::group(['middleware' => 'auth:api'], function() {

        // تحديث وحذف (مسموح للمستخدم وللأدمن حسب المنطق في الكنترولر)
        Route::put('/users/{id}', [AuthController::class, 'update']);
        Route::delete('/users/{id}', [AuthController::class, 'destroy']);

        // عرض المستخدمين (للأدمن فقط)
        Route::get('/users', [AuthController::class, 'index'])->middleware('role:admin');
    });
});

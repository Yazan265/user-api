<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

// الصفحات الرئيسية
Route::get('/', function () {
    return view('home');
})->name('home');
// صفحات المصادقة
Route::middleware('guest')->group(function () {
    // تسجيل الدخول
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'loginWeb'])->name('login.post');

    // التسجيل
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', [AuthController::class, 'registerWeb'])->name('register.post'); // تغيير الاسم هنا
});

// المسارات المحمية (تتطلب تسجيل الدخول)
Route::middleware('auth')->group(function () {
    // لوحة التحكم
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'changePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  // إدارة المستخدمين (للمدراء فقط)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

    // تسجيل الخروج
    Route::post('/logout', [AuthController::class, 'logoutWeb'])->name('logout');
});

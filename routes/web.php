<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// تحويل المستخدم إلى صفحة تسجيل الدخول مباشرة من الصفحة الرئيسية
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/user_dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ترجمة المسارات وتوجيهات الـ admin والـ user
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth'],
], function () {
    Route::group(['middleware' => ['is_admin']], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('Admindashboard');
    });

    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::get('redirect', [HomeController::class, 'redirect']);
});
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

// مسار معالجة تسجيل الدخول
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

// مسار تسجيل الخروج
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SecondProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('products', ProductController::class);
Route::post('products/upload-barcode', [ProductController::class, 'uploadBarcode']);
// Route::post('products/get-price', [ProductController::class, 'getPriceByBarcode']);

Route::apiResource('second-products', SecondProductController::class);

Route::post('register', [RegisteredUserController::class, 'store']); // تسجيل حساب جديد
Route::post('login', [AuthenticatedSessionController::class, 'store']); // تسجيل الدخول
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // 🔹 انقل هذا السطر هنا
});






// // استعادة كلمة المرور
// Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
// Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
// // تأكيد كلمة المرور
// Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])->middleware('auth:sanctum');
// // تحديث كلمة المرور
// بيانات الملف الشخصي
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

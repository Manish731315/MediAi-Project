<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AIChatController;
// use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\VerificationController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/shop', [MedicineController::class, 'index'])->name('shop.index');
Route::get('/shop/{medicine}', [MedicineController::class, 'show'])->name('shop.show');

// Google OAuth Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// Allow Google users to set a password if they don't have one
Route::get('/set-password', function () {
    return view('auth.set-password');
})->middleware('auth')->name('password.set');

Route::post('/set-password', [ProfileController::class, 'setPassword'])->middleware('auth');
// OTP Verification Routes
Route::get('/verify-account', [VerificationController::class, 'notice'])->name('verification.notice');
Route::post('/verify-account', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/verify-account/resend', [VerificationController::class, 'resend'])->name('verification.resend');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{medicine}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/checkout/verify', [CheckoutController::class, 'verifyPayment'])->name('checkout.verify');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    // Prescription Upload
    Route::get('/checkout/{order}/upload-prescription', [PrescriptionController::class, 'showUploadForm'])
        ->name('prescription.upload');
    Route::post('/checkout/{order}/upload-prescription', [PrescriptionController::class, 'storeUpload'])
        ->name('prescription.store');

    // AI Chat
    Route::post('/ai/chat/process', [AIChatController::class, 'process'])->name('ai.chat.process');

    // User Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Orders
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/download-invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin Product CRUD
    Route::resource('medicines', MedicineController::class)->except(['index', 'show']);
    Route::get('medicines', [MedicineController::class, 'adminIndex'])->name('medicines.index');
    // User Management
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    // Order Management
    Route::get('/orders', [AdminController::class, 'ordersIndex'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'ordersShow'])->name('orders.show');
    Route::post('/orders/{order}/update-status', [AdminController::class, 'ordersUpdateStatus'])->name('orders.updateStatus');

    // Prescription Approval
    Route::post('/prescriptions/{prescription}/approve', [AdminController::class, 'approvePrescription'])->name('prescriptions.approve');
    Route::post('/prescriptions/{prescription}/reject', [AdminController::class, 'rejectPrescription'])->name('prescriptions.reject');

    // AI Chat Logs
    Route::get('/chat-logs', [AdminController::class, 'chatLogs'])->name('chat.logs');
   
});


// Include default Laravel auth routes
require __DIR__.'/auth.php';

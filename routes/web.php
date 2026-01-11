<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MedicineController,
    CartController,
    CheckoutController,
    PrescriptionController,
    AIChatController,
    ProfileController,
    OrderController,
    GoogleAuthController,
    VerificationController,
    ShopController
};
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MedicineController as AdminMedicineController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Shop / Products
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{medicine}', [ShopController::class, 'show'])->name('shop.show');

// Google OAuth
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// OTP Verification
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

    // Google User Password Setup
    Route::get('/set-password', function () {
        return view('auth.set-password');
    })->name('password.set');
    Route::post('/set-password', [ProfileController::class, 'setPassword']);

    // Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{medicine}', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{cart}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{cart}', [CartController::class, 'remove'])->name('remove');
    });

    // Checkout
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'store'])->name('store');
        Route::post('/verify', [CheckoutController::class, 'verifyPayment'])->name('verify');
        Route::get('/success', [CheckoutController::class, 'success'])->name('success');
    });

    // Prescription Upload
    Route::get('/checkout/{order}/upload-prescription', [PrescriptionController::class, 'showUploadForm'])->name('prescription.upload');
    Route::post('/checkout/{order}/upload-prescription', [PrescriptionController::class, 'storeUpload'])->name('prescription.store');

    // Orders & Invoices
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/download-invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');

    // AI Chat
    Route::post('/ai/chat/process', [AIChatController::class, 'process'])->name('ai.chat.process');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin Medicine Management (CRUD)
    // This handles index, create, store, edit, update, destroy
    Route::resource('medicines', AdminMedicineController::class);

    // User Management
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');

    // Order & Prescription Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminController::class, 'ordersIndex'])->name('index');
        Route::get('/{order}', [AdminController::class, 'ordersShow'])->name('show');
        Route::post('/{order}/update-status', [AdminController::class, 'ordersUpdateStatus'])->name('updateStatus');
    });

    Route::post('/prescriptions/{prescription}/approve', [AdminController::class, 'approvePrescription'])->name('prescriptions.approve');
    Route::post('/prescriptions/{prescription}/reject', [AdminController::class, 'rejectPrescription'])->name('prescriptions.reject');

    // AI Chat Logs
    Route::get('/chat-logs', [AdminController::class, 'chatLogs'])->name('chat.logs');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

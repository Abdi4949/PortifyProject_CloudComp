<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TemplateController; 
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\UpgradeController;
use App\Http\Controllers\PaymentCallbackController; 
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TransactionController; 
use App\Http\Controllers\Admin\TemplateController as AdminTemplateController; 
use App\Http\Controllers\GoogleAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (Authenticated Users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (from Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== AUTHENTICATED USER ROUTES ====================
Route::middleware('auth')->group(function () {
    
    // Templates (User Side)
    Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/{id}', [TemplateController::class, 'show'])->name('templates.show');
    Route::post('/templates/{id}/select', [TemplateController::class, 'select'])->name('templates.select');
    
    // Portfolios
    Route::resource('portfolios', PortfolioController::class);
    
    // Export (Logic Lama / Data Mining)
    Route::get('/export/check-limit', [ExportController::class, 'checkLimit'])->name('export.check-limit');
    Route::post('/portfolios/{id}/export', [ExportController::class, 'export'])->name('portfolios.export');
    Route::get('/exports/history', [ExportController::class, 'history'])->name('exports.history');
    
    // Upgrade / Payment
    Route::get('/upgrade', [UpgradeController::class, 'index'])->name('upgrade');
    Route::post('/upgrade/checkout', [UpgradeController::class, 'checkout'])->name('upgrade.checkout');
    Route::get('/upgrade/finish', [UpgradeController::class, 'paymentFinish'])->name('upgrade.finish');
    Route::get('/upgrade/pending', [UpgradeController::class, 'paymentPending'])->name('upgrade.pending');
    Route::get('/upgrade/error', [UpgradeController::class, 'paymentError'])->name('upgrade.error');

    // EXPORT PDF
    Route::get('/portfolios/{id}/export-pdf', [PortfolioController::class, 'exportPdf'])->name('portfolios.exportPdf');
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{id}/activate', [AdminUserController::class, 'activate'])->name('users.activate');
    Route::post('/users/{id}/upgrade-pro', [AdminUserController::class, 'upgradeToPro'])->name('users.upgrade-pro');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // Templates Management (Admin Side)
    Route::get('/templates', [AdminTemplateController::class, 'index'])->name('templates.index');
    Route::patch('/templates/{id}/toggle', [AdminTemplateController::class, 'togglePublish'])->name('templates.toggle');
    
    // Transactions Management
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    
    // Activity Logs
    Route::get('/logs', function () {
        return view('coming-soon', ['feature' => 'Activity Logs']);
    })->name('logs.index');
});

// Route untuk melempar ke Google
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');

// Route untuk callback dari Google
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

require __DIR__.'/auth.php';
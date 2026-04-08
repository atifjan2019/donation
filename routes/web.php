<?php

use App\Http\Controllers\Admin\AdminCampaignController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDonationController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicCampaignController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('campaigns.index');
});

Route::get('/campaigns', [PublicCampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaign/{slug}', [PublicCampaignController::class, 'show'])->name('campaigns.show');

Route::get('/donate', [DonationController::class, 'create'])->name('donations.create');
Route::post('/donate', [DonationController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('donations.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'overview'])->name('dashboard');
    Route::get('/dashboard/history', [UserDashboardController::class, 'history'])->name('dashboard.history');
    Route::get('/dashboard/recurring', [UserDashboardController::class, 'recurring'])->name('dashboard.recurring');
    Route::patch('/dashboard/recurring/{recurringDonationId}/status', [UserDashboardController::class, 'updateRecurringStatus'])
        ->name('dashboard.recurring.status');
    Route::get('/dashboard/receipts', [UserDashboardController::class, 'receipts'])->name('dashboard.receipts');
    Route::get('/dashboard/receipts/{year}/bundle', [UserDashboardController::class, 'yearlyReceiptBundle'])
        ->name('dashboard.receipts.bundle');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
        Route::get('/donations/{donation}', [AdminDonationController::class, 'show'])->name('donations.show');
        Route::patch('/donations/{donation}/refund', [AdminDonationController::class, 'refund'])->name('donations.refund');

        Route::apiResource('campaigns', AdminCampaignController::class);
        Route::post('/campaigns/{campaign}/duplicate', [AdminCampaignController::class, 'duplicate'])->name('campaigns.duplicate');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

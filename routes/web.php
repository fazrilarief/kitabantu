<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\FundraiserController;
use App\Http\Controllers\FundraisingController;
use App\Http\Controllers\FundraisingPhasesController;
use App\Http\Controllers\FundraisingWithdrwalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function(){
        Route::resource('categories', CategoryController::class)
        ->middleware('role:owner');

        Route::resource('donaturs', DonaturController::class)
        ->middleware('role:owner');

        Route::resource('fundraisers', FundraiserController::class)
        ->middleware('role:owner')->except('index');

        Route::get('fundraisers', [FundraiserController::class, 'index'])
        ->name('fundraisers.index');

        Route::resource('fundraising_withdrawls', FundraisingWithdrwalController::class)
        ->middleware('role:owner|fundraiser');

        Route::post('/fundraising_withdrawls/request/{fundraising}', [FundraisingWithdrwalController::class, 'store'])
        ->middleware('role:fundraiser')
        ->name('fundraising_withdrawl.store');

        Route::resource('fundraising_phases', FundraisingPhasesController::class)
        ->middleware('role:owner|fundraiser');

        Route::post('/fundraising_phases/update/{fundraising}', [FundraisingPhasesController::class, 'store'])
        ->middleware('role:fundraiser')
        ->name('fundraising_phases.store');

        Route::resource('fundraisings', FundraisingController::class)
        ->middleware('role:owner|fundraiser');

        Route::post('/fundraisings/active/fundraising', [fundraisingController::class, 'activate_fundraising'])
        ->middleware('role:owner')
        ->name('activate_fundraising');

        Route::post('/fundraiser/apply', [DashboardController::class, 'apply_fundraiser'])
        ->name('fundraiser.apply');

        Route::get('/my-withdrawls', [DashboardController::class, 'my_withdrawls'])
        ->name('my-withdrawals');

        Route::post('/my-withdrawls/details/{fundraisingWithdrwal}', [DashboardController::class, 'my_withdrawal'])
        ->name('my-withdrawals.details');


    });
});

require __DIR__.'/auth.php';

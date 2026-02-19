<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', \App\Http\Controllers\UserController::class);

    // Main Banner Designer (Single Page with Multi-BG)
    Route::get('heroes', [\App\Http\Controllers\HeroController::class, 'index'])->name('heroes.index');
    Route::post('heroes', [\App\Http\Controllers\HeroController::class, 'store'])->name('heroes.store');

    Route::resource('partners', \App\Http\Controllers\PartnerController::class);
    Route::get('offer-categories/check-uniqueness', [\App\Http\Controllers\OfferCategoryController::class, 'checkUniqueness'])->name('offer-categories.check-uniqueness');
    Route::resource('offer-categories', \App\Http\Controllers\OfferCategoryController::class);
    Route::post('offers/{offer}/duplicate', [\App\Http\Controllers\OfferController::class, 'duplicate'])->name('offers.duplicate');
    Route::resource('offers', \App\Http\Controllers\OfferController::class);
    Route::resource('transportations', \App\Http\Controllers\TransportationController::class);
    Route::get('transportation-page', [\App\Http\Controllers\TransportationPageController::class, 'edit'])->name('transportations.page.edit');
    Route::post('transportation-page', [\App\Http\Controllers\TransportationPageController::class, 'update'])->name('transportations.page.update');
    Route::resource('faqs', \App\Http\Controllers\FaqController::class);
    Route::resource('restaurants', \App\Http\Controllers\RestaurantController::class);
    Route::resource('destinations', \App\Http\Controllers\DestinationController::class);
    Route::resource('reviews', \App\Http\Controllers\ReviewController::class);
    Route::resource('visas', \App\Http\Controllers\VisaController::class);
    Route::resource('hotels', \App\Http\Controllers\HotelController::class);
    Route::post('hotel-types', [\App\Http\Controllers\HotelTypeController::class, 'store'])->name('hotel-types.store');
    Route::get('settings', [\App\Http\Controllers\GeneralSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\GeneralSettingController::class, 'update'])->name('settings.update');
    Route::post('provinces', [\App\Http\Controllers\ProvinceController::class, 'store'])->name('provinces.store');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('api/provinces', [\App\Http\Controllers\ProvinceController::class, 'index'])->name('provinces.api');
    Route::post('offer-types', [\App\Http\Controllers\OfferTypeController::class, 'store'])->name('offer-types.store');
    Route::get('api/offer-types', [\App\Http\Controllers\OfferTypeController::class, 'index'])->name('offer-types.api');
    Route::post('ratings', [\App\Http\Controllers\RatingController::class, 'store'])->name('ratings.store');
    Route::get('api/ratings', [\App\Http\Controllers\RatingController::class, 'index'])->name('ratings.api');
});

require __DIR__ . '/auth.php';

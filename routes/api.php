<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::prefix('v1')->group(function () {
    Route::get('/settings', [ApiController::class, 'settings']);
    Route::get('/visa', [ApiController::class, 'visa']);
    Route::get('/heroes', [ApiController::class, 'heroes']);
    Route::get('/partners', [ApiController::class, 'partners']);
    Route::get('/categories', [ApiController::class, 'categories']);
    Route::get('/offers', [ApiController::class, 'offers']);
    Route::get('/offers/{id}', [ApiController::class, 'offerShow']);
    Route::get('/hotels', [ApiController::class, 'hotels']);
    Route::get('/hotels/{id}', [ApiController::class, 'hotelShow']);
    Route::get('/destinations', [ApiController::class, 'destinations']);
    Route::get('/destinations/{id}', [ApiController::class, 'destinationShow']);
    Route::get('/restaurants', [ApiController::class, 'restaurants']);
    Route::get('/reviews', [ApiController::class, 'reviews']);
    Route::get('/faqs', [ApiController::class, 'faqs']);
    Route::get('/transportations', [ApiController::class, 'transportations']);
});

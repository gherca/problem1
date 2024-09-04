<?php

use App\Discount\Infrastructure\Http\Controllers\DiscountController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/discounts', DiscountController::class);
});


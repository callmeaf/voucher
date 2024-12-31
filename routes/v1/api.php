<?php

use \Illuminate\Support\Facades\Route;

Route::prefix(config('callmeaf-base.api.prefix_url'))->as(config('callmeaf-base.api.prefix_route_name'))->middleware(config('callmeaf-base.api.middlewares'))->group(function() {
    // Vouchers
    Route::apiResource('vouchers',config('callmeaf-voucher.controllers.vouchers'));
    Route::prefix('vouchers')->as('vouchers.')->controller(config('callmeaf-voucher.controllers.vouchers'))->group(function() {
        Route::prefix('{voucher}')->group(function() {
            Route::patch('/status','statusUpdate')->name('status_update');
        });
    });
});


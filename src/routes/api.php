<?php

use Illuminate\Support\Facades\Route;
use Seat\SharkordConnector\Http\Controllers\LoginExportController;

Route::prefix('api/sharkord-connector')->group(function (): void {
    Route::post('/login-export', LoginExportController::class);
});

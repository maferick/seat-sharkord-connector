<?php

use Illuminate\Support\Facades\Route;
use Seat\SharkordConnector\Http\Controllers\DiagnosticsController;
use Seat\SharkordConnector\Http\Controllers\SettingsController;
use Seat\SharkordConnector\Http\Controllers\TestSyncController;

Route::prefix('sharkord-connector')->group(function (): void {
    Route::get('/settings', [SettingsController::class, 'index'])->name('sharkord-connector.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('sharkord-connector.settings.update');
    Route::get('/diagnostics', DiagnosticsController::class)->name('sharkord-connector.diagnostics');
    Route::post('/preview', [TestSyncController::class, 'preview'])->name('sharkord-connector.preview');
    Route::post('/upsert', [TestSyncController::class, 'upsert'])->name('sharkord-connector.upsert');
});

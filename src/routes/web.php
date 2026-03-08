<?php

use Illuminate\Support\Facades\Route;
use Seat\SharkordConnector\Http\Controllers\DiagnosticsController;
use Seat\SharkordConnector\Http\Controllers\RoleMappingController;
use Seat\SharkordConnector\Http\Controllers\SettingsController;
use Seat\SharkordConnector\Http\Controllers\TestSyncController;
use Seat\SharkordConnector\Http\Controllers\UserFlowController;

Route::prefix('sharkord-connector')->group(function (): void {
    Route::get('/settings', [SettingsController::class, 'index'])->name('sharkord-connector.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('sharkord-connector.settings.update');

    Route::get('/mappings', [RoleMappingController::class, 'index'])->name('sharkord-connector.mappings');
    Route::post('/mappings', [RoleMappingController::class, 'store'])->name('sharkord-connector.mappings.store');
    Route::delete('/mappings/{mapping}', [RoleMappingController::class, 'destroy'])->name('sharkord-connector.mappings.destroy');

    Route::get('/user-flow', [UserFlowController::class, 'index'])->name('sharkord-connector.user-flow');
    Route::post('/user-flow/link', [UserFlowController::class, 'link'])->name('sharkord-connector.user-flow.link');
    Route::post('/user-flow/resync', [UserFlowController::class, 'resync'])->name('sharkord-connector.user-flow.resync');
    Route::post('/user-flow/reset-password', [UserFlowController::class, 'resetPassword'])->name('sharkord-connector.user-flow.reset-password');

    Route::get('/diagnostics', DiagnosticsController::class)->name('sharkord-connector.diagnostics');
    Route::post('/preview', [TestSyncController::class, 'preview'])->name('sharkord-connector.preview');
    Route::post('/upsert', [TestSyncController::class, 'upsert'])->name('sharkord-connector.upsert');
});

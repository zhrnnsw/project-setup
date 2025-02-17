<?php
use Illuminate\Support\Facades\Route;
use zhrnnsw\ProjectSetup\Controllers\SetupController;

Route::prefix('setup')->group(function () {
    Route::get('/', [SetupController::class, 'index'])->name('setup.index');
    Route::post('/run', [SetupController::class, 'runSetup'])->name('setup.run');
});
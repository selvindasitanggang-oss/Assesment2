<?php

use Illuminate\Support\Facades\Route;
use Modules\TitikDrainase\Http\Controllers\TitikDrainaseController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('titikdrainases', TitikDrainaseController::class)->names('titikdrainase');
});

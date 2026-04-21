<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoctorApiController;
use App\Http\Controllers\Api\AppointmentApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('doctors', DoctorApiController::class);
    Route::apiResource('appointments', AppointmentApiController::class);
});
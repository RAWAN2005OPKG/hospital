<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('logout', function () {
        auth()->logout();
        return redirect()->route('home');
    })->name('logout');
});

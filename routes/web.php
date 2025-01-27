<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttemptStatusController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('attemptstatuses', AttemptStatusController::class);

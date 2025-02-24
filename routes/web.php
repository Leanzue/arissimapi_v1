<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SendStatusController;
use App\Http\Controllers\SendResultController;
use App\Http\Controllers\SimRequestController;
use App\Http\Controllers\SendAttemptController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\AttemptStatusController;
use App\Http\Controllers\RequestStatusController;
use App\Http\Controllers\AttemptResultController;
use App\Http\Controllers\SendAttemptResultController;
use App\Http\Controllers\TreatmentAttemptController;

Route::get('/', function () {
    return view('welcome');
    Route::resource('requestedsims', SimController::class)->names('sims');
    Route::resource('requestedsims', SimController::class)->names('sims');
    Route::resource('requestedsims', SimController::class)->names('sims');
    Route::resource('requestedsims', SimController::class)->names('sims');
    Route::resource('requestedsims', SimController::class)->names('sims');
    Route::resource('simrequests', SimRequestController::class);
    Route::resource('statuses', StatusController::class);
    Route::resource('treatmentattempts', TreatmentAttemptController::class);
    Route::resource('attemptresults', AttemptResultController::class);
});

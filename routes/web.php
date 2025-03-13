<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\SimRequestController;
use App\Http\Controllers\SimResponseController;
use App\Http\Controllers\TreatmentStatusController;
use App\Http\Controllers\TreatmentResultController;
use App\Http\Controllers\TreatmentAttemptController;

Route::prefix('api')->group(function () {
    //Route::resource('sims', SimController::class)->parameters([
       // 'simsrequested' => 'sims']);
    Route::get('simrequested', [SimController::class, 'sims']);
   // Route::resource('sims', SimController::class);
    Route::resource('simrequests', SimRequestController::class);
    Route::resource('simresponses', SimResponseController::class);
    Route::resource('statuses', StatusController::class);
    Route::resource('treatments', TreatmentController::class);
    Route::resource('treatmentattempts', TreatmentAttemptController::class);
    Route::resource('treatmentresults', TreatmentResultController::class);
    Route::resource('treatmentstatuses', TreatmentStatusController::class);
});


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirestoreController;


Route::prefix('firestore')->group(function () {
    Route::get('/', [FirestoreController::class, 'index']);
    Route::post('/', [FirestoreController::class, 'store']);
    Route::get('/{id}', [FirestoreController::class, 'show']);
    Route::put('/{id}', [FirestoreController::class, 'update']);
    Route::delete('/{id}', [FirestoreController::class, 'destroy']);
});


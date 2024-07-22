<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;

Route::prefix('player')->group(function () {
    Route::get('/', [PlayerController::class, 'list']);
    Route::put('/', [PlayerController::class, 'add']);
    Route::post('/', [PlayerController::class, 'add']);
    Route::put('/{id}', [PlayerController::class, 'edit']);
    Route::post('/{id}', [PlayerController::class, 'edit']);
    Route::delete('/{id}', [PlayerController::class, 'remove']);
});

Route::prefix('team')->group(function () {
    Route::get('/process', [TeamController::class, 'process']);
});

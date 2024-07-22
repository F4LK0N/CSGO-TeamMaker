<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/player', function (Request $request) {
    return $request->user();
});

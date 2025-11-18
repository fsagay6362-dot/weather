<?php
use Illuminate\Support\Facades\Route;

use App\Models\Pressure;

Route::get('/press', fn() => Pressure::orderBy('recorded_at')->get());
Route::get('/pressures', function () {
    return view('pressures');
});

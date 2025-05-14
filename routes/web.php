<?php

use App\Http\Controllers\PredictionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('many-gawangan-manuals/export', [\App\Http\Controllers\ManyGawanganManualController::class, 'export'])
->name('users.export');

Route::get('/prediction', [PredictionController::class, 'index']);
Route::post('/predict', [PredictionController::class, 'predict'])->name('predict');
Route::post('/get-chart-data', [PredictionController::class, 'getChartData']);

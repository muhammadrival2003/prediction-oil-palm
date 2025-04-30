<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('many-gawangan-manuals/export', [\App\Http\Controllers\ManyGawanganManualController::class, 'export'])
->name('users.export');

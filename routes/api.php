<?php

use App\Http\Controllers\Configuration\ESchoolResourceController;
use Illuminate\Support\Facades\Route;

Route::post('/config',[ESchoolResourceController::class => 'index'])->name('config.index');

Route::get('/config', fn() => response(['data' => 'sinatra']));


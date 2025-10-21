<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsController;

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{news}', [NewsController::class, 'show'])->whereNumber('news');
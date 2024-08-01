<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FotoController;
Route::resource("/foto", FotoController::class);

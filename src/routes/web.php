<?php

#Conveção: Importações estarem em ordem alfabética

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::resource('filmes', MovieController::class);
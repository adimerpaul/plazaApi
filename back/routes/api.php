<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::post('/login', [\App\Http\Controllers\UserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/me', [\App\Http\Controllers\UserController::class, 'me']);
    Route::post('/logout', [\App\Http\Controllers\UserController::class, 'logout']);

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
    Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'delete']);
    Route::put('/passwordUpdate/{id}', [\App\Http\Controllers\UserController::class, 'passwordUpdate']);

    Route::get('/movies', [\App\Http\Controllers\MovieController::class, 'index']);
    Route::post('/movies', [\App\Http\Controllers\MovieController::class, 'store']);
    Route::put('/movies/{id}', [\App\Http\Controllers\MovieController::class, 'update']);
    Route::delete('/movies/{id}', [\App\Http\Controllers\MovieController::class, 'destroy']);
});
//rutas para moviles on api/mobil/asa
Route::group(['prefix' => 'mobil'], function(){
    Route::get('/peliculas', [\App\Http\Controllers\MovieController::class, 'peliculas']);
    Route::get('/proximos', [\App\Http\Controllers\MovieController::class, 'proximos']);
});


Route::get('/compromiso/{loan_id}', [\App\Http\Controllers\ReportController::class, 'compromiso']);

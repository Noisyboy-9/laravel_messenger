<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// auth

use App\Http\Controllers\auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post("auth/register", [RegisterController::class, "store"]);
//Route::post("auth/login", []);

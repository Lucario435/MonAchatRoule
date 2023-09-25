<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get("/welcome",function(){
    return view("welcome");
});

Route::get('/users',[UsersController::class,"index"]);
Route::get('/users/{id}',[UsersController::class,"index"]);

Route::get('/login',[UsersController::class,"login"]);

Route::get('/register',[UsersController::class,"register"]);
Route::post('/register',[UsersController::class,"store"]);
Route::get('/confirm-email',[UsersController::class,"confirmEmail"]);

Route::get('/users/login',[UsersController::class,"login"]);
Route::get('/users/register',[UsersController::class,"register"]);

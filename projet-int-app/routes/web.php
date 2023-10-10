<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Auth;
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
// ceci est la page index...
Route::get('/', function () {
    return view('home');
})->name('index');

Route::get("/index",function(){
    return to_route("index");
});

Route::get('/users',[UsersController::class,"index"]);
Route::get('/users/{id}',[UsersController::class,"userProfile"]);
// login momo
Route::post('/login',[UsersController::class,"authenticate"]);
Route::get('/login',[UsersController::class,"login"])->name('login');
Route::get("/logout",[UsersController::class,"logout"]);
Route::get("/favoris",function(){
    return view("favoris");
});


// Story #3 Chahine

// Inscription --------------------
Route::get('/register',[UsersController::class,"register"])->name('register');
Route::post('/register',[UsersController::class,"store"]);

// Verification email --------------
Route::get('/email/verifier/{id}/{hash}',
function (EmailVerificationRequest $request) {
    $request->fulfill();
    return view("confirm-email",["email_verified"=>1]);
})->middleware(['auth','signed'])->name('verification.verify');
// FIN Story #3 Chahine



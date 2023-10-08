<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PublicationController;

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

Route::get('/login',[UsersController::class,"login"])->name('login');
Route::get('/register',[UsersController::class,"register"]);
Route::post('/register',[UsersController::class,"registerWData"]);
Route::get('/users/login',[UsersController::class,"login"]);
Route::get('/users/register',[UsersController::class,"register"]);


//Section for publication routes
//------------------------------------------------------------------------------------
//Route to show main page
Route::get('/publication', [PublicationController::class, 'index'])->name('publication.index');
//Route to create show publication page
Route::get('/publication/create', [PublicationController::class, 'create'])->name('publication.create');
//Route to create the publication (SAVE)
Route::post('/publication', [PublicationController::class, 'store'])->name('publication.store');
//------------------------------------------------------------------------------------

//Section for image routes
//------------------------------------------------------------------------------------
//Route to show create image page
Route::get('/image/create', [ImageController::class, 'create'])->name('image.create');
//Route to create the images (SAVE)
Route::post('/image', [ImageController::class, 'store'])->name('image.store');
//------------------------------------------------------------------------------------
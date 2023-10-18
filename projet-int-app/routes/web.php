<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\PublicationFollow;
use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use App\Models\Image;

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
    $publications = Publication::all();
    $images = Image::all();
    return view('publications.index', ['publications' => $publications, 'images' => $images]);
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
})->middleware("verified");

// Temporaire avant commit login de mohammed - chahine
Route::get('/login',[UsersController::class,"login"])->name('login');
Route::post('/login',[UsersController::class,"authenticate"]);

// Story #3 Chahine

// Inscription --------------------
Route::get('/register',[UsersController::class,"register"])->name('register');
Route::post('/register',[UsersController::class,"store"]);

// Verification email --------------
Route::get('/email/verifier/{id}/{hash}',
function (EmailVerificationRequest $request) {
    $status = Auth::user()->email_verified_at == null ? 1 : 2;
    $request->fulfill();
    return view("confirm-email",["email_verified_now"=>$status]);
})->middleware(['auth','signed'])->name('verification.verify');
// FIN Story #3 Chahine


// Story #9 page apropos
Route::view('/a-propos','a-propos');
Route::view('/about','a-propos');
Route::get('/email/verify/unconfirmed',function(){
    return view("confirm-email",["email_verified_now" => 3]);
})->name("verification.notice");
// FIN Story #3 Chahine

// Story #9 page apropos
Route::get('/login',[UsersController::class,"login"])->name('login');
Route::get('/users/login',[UsersController::class,"login"]);
Route::get('/users/register',[UsersController::class,"register"]);


//Section for publication routes
//------------------------------------------------------------------------------------
//Route to show main page
Route::get('/publication', [PublicationController::class, 'index'])->name('publication.index');
//Route to create show publication page
Route::get('/publication/create', [PublicationController::class, 'create'])->middleware('verified')->name('publication.create');
Route::get('/publication/edit/{id}', [PublicationController::class, 'viewupdate'])->middleware('verified')->name('publication.getupdateview');
Route::post('/publication/edit/{id}', [PublicationController::class, 'update'])->middleware('verified')->name('publication.update');
//Route to create the publication (SAVE)
Route::post('/publication', [PublicationController::class, 'store'])->name('publication.store');
//Route to create the detail page
Route::get('publication/detail/{id}', [PublicationController::class, 'detail'])->name('publication.detail');
//------------------------------------------------------------------------------------

//Section for image routes
//------------------------------------------------------------------------------------
//Route to show create image page
Route::get('/image/create', [ImageController::class, 'create'])->middleware('verified')->name('image.create');
//momo
Route::get("/image/publication",function(){
    return to_route("index");
});
Route::get('/image/delete/{id}', [ImageController::class, 'deleteImage'])->middleware('verified')->name('image.delete');
Route::get('/image/edit/{id}', [ImageController::class, 'edit_annonce'])->middleware('verified')->name('image.edit');
Route::post('/image/edit/{id}', [ImageController::class, 'edit_annonce_recu'])->middleware('verified')->name('image.update');
//Route to create the images (SAVE)
Route::post('/image', [ImageController::class, 'store'])->middleware("verified")->name('image.store');
//------------------------------------------------------------------------------------

//Section for favoritePublicaitons routes
//------------------------------------------------------------------------------------
//Route to show create image page
Route::get('/publicationfollow', [PublicationFollow::class, 'index'])->name('publicationfollow.index')->middleware("verified");
//Route to store the follow on a publication
Route::get('publicaitonfollow', [PublicationFollow::class, 'store'])->name('publicationfollow.store');
//------------------------------------------------------------------------------------
// Search by filter
Route::get('/publications/search',[PublicationController::class,'search']);
// Section for api/publications in order to filter
Route::get('/api/publications/brands',function ()
    {
        return PublicationResource::collection(Publication::all())->countBy('brand');
    }
);
Route::get('/api/publications/bodies',function ()
    {
        return PublicationResource::collection(Publication::all())->countBy('bodyType');
    }
);
Route::get('/api/publications/transmissions',function ()
    {
        return PublicationResource::collection(Publication::all())->countBy('transmission');
    }
);

Route::get('/api/publications/maxPrice',function ()
    {
        return PublicationResource::collection(Publication::all())->max('fixedPrice');
    }
);
Route::get('/api/publications/maxKilometer',function ()
    {
        return PublicationResource::collection(Publication::all())->max('kilometer');
    }
);
// Route::get('/api/publications/kilometer',function ()
//     {
//         return PublicationResource::collection(Publication::all())->pluck('brand');
//     }
// );

<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PublicationFollow;
use App\Http\Controllers\ComparatorController;
use App\Http\Controllers\ReportController;
use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use App\Models\Image;
use App\Http\Controllers\SignalementController;
use App\Models\notification;



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
Route::get("/errorx",function(){
    return to_route("index");//,["xalert"=>"Une erreur est survenue"]);
})->name("error");
Route::get("/index",function(){
    return to_route("index");
});

Route::get('/notifications',[NotificationController::class,"index"])->name("notifications")->middleware(['auth','verified']);
Route::get('/notifications/{nid}',[NotificationController::class,"click"])->name("notifications.click")->middleware(['auth','verified']);
Route::get('/notifications/del/{nid}',[NotificationController::class,"delete"])->name("notifications.delete")->middleware(['auth','verified']);
Route::post('/notifications/mdel',[NotificationController::class,"multidelete"])->name("notifications.multidelete")->middleware(['auth','verified']);
//messages momo
// Route::get("/rs",function(){
    // return view("messagerie.rateSeller",["vid" => 1, "uid"=>1]);
// })->middleware(['auth','verified']);
Route::get('/messages/del/{id}',[ChatController::class,"userdelete"])->name("messages.userdelete")->middleware(['auth','verified']);
Route::get('/messages',[ChatController::class,"index"])->middleware('verified')->name("messages")->middleware(['auth','verified']);
Route::post("/bought/set/",[ChatController::class,"markAsBuyerPost"])->name("messages.markAsBuyerPost")->middleware(['auth','verified']);
Route::get("/bought/{uid}",[ChatController::class,"markAsBuyer"])->name("messages.markAsBuyer")->middleware(['auth','verified']);
Route::get("/rateseller/{uid}/{vid}",[ChatController::class,"rateSeller"])->name("messages.rateSellerLeg")->middleware(['auth','verified']);
Route::get("/eval/{uid}/{vid}",[ChatController::class,"rateSeller"])->name("messages.rateSeller")->middleware(['auth','verified']);
Route::get("/evalx/edit/{rid}",[ChatController::class,"rateSellerEdit"])->name("messages.rateSellerEdit");
Route::post("/evalx/editdone/",[ChatController::class,"rateSellerEditPost"])->name("messages.rateSellerEditPost")->middleware(['auth','verified']);
Route::get("/evalx/del/{rid}",[ChatController::class,"rateSellerDelete"])->name("messages.rateSellerDelete")->middleware(['auth','verified']);
Route::post("/evalsend",[ChatController::class,"rateSellerPost"])->name("messages.rateSellerPost")->middleware(['auth','verified']);
Route::get('/auction/ended/{pid}',[ChatController::class,"sellerSeeBiddersEnd"])->name("messages.sellerSeeBiddersEnd")->middleware(['auth','verified']);
Route::get("/messages/report/{id}",[ChatController::class,"reportuser"])->name("messages.reportuser")->middleware(['auth','verified']);
Route::get('/Chat/GetMessages',[ChatController::class,"get"])->name("getmessages")->middleware(['auth','verified'])->middleware(['auth','verified']);
Route::get("/messages/blockmsg/{id}",[ChatController::class,"blockUserMsgs"])->name("messages.blockUserMsgs")->middleware(['auth','verified']);
Route::get('/messages/{id}',[ChatController::class,"index"])->name("messageUser")->middleware(['auth','verified']);
Route::get('/messages/{id}/{pid}',[ChatController::class,"messageUserFromPID"])->name("messageUserFromPID")->middleware(['auth','verified']);
Route::get('/Chat/GetFriendsList',[ChatController::class,"GetFriendsList"])->name("GetFriendsList")->middleware(['auth','verified']);
Route::get("/Chat/SetCurrentTarget",[ChatController::class,"SetCurrentTarget"])->name("setcurrenttarget")->middleware(['auth','verified']);
Route::get("/Chat/Send",[ChatController::class,"Send"])->name("sendmessage")->middleware(['auth','verified']);
Route::get('/users',[UsersController::class,"index"])->middleware(['auth','verified']);
Route::get('/users/edit',[UsersController::class,"edit"])->name("user.edit")->middleware(['auth','verified']);
Route::post('/users/edit',[UsersController::class,"editPost"])->name("user.update")->middleware(['auth','verified']);
Route::get('/users/{id}',[UsersController::class,"userProfile"])->name("userProfile");//->middleware(['auth','verified']);
// login momo
Route::post('/login',[UsersController::class,"authenticate"]);
Route::get('/login',[UsersController::class,"login"])->name('login');
Route::get("/logout",[UsersController::class,"logout"]);
Route::get("/favoris",function(){
    return view("favoris");
})->middleware(['auth','verified']);
//report momo
Route::get("/report",[ReportController::class,"reportView"])->middleware(['auth','verified'])->name("report");
Route::get("/report/create",function(){
    return to_route("report");
});
Route::post("/report/create",[ReportController::class,"reportPost"])->middleware(['auth','verified'])->name("report.post");
// Temporaire avant commit login de momo - chahine
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
Route::view('/about','a-propos')->name("about");
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
Route::get('/publication/create', [PublicationController::class, 'create'])->middleware(['auth','verified'])->name('publication.create');
Route::get('/publication/edit/{id}', [PublicationController::class, 'viewupdate'])->middleware('verified')->name('publication.getupdateview');
Route::post('/publication/edit/{id}', [PublicationController::class, 'update'])->middleware('verified')->name('publication.update');
//Route to create the publication (SAVE)
Route::post('/publication', [PublicationController::class, 'store'])->name('publication.store');
//Route to create the detail page
Route::get("/publication/{id}",[PublicationController::class,"detail"]);
Route::get('publication/detail/{id}', [PublicationController::class, 'detail'])->name('publication.detail');
//Route to set a publication as sold
Route::get('publication/sold/{id}', [PublicationController::class, 'markAsSold'])->name('publication.sold');
//Route to delete a publication
Route::get('publication/delete/{id}', [PublicationController::class, 'delete'])->name('publication.delete');
//Route to go to comparator
Route::get('comparator/{car1}/{car2}', [ComparatorController::class, 'index'])->name('comparators.index');
//------------------------------------------------------------------------------------

//Section for bids routes
//------------------------------------------------------------------------------------
Route::post('/bid', [BidController::class, 'store'])->name('bid.store');

//Used to make a partial refresh in the detail page
Route::get('/refresh-div/{id}', [BidController::class, 'refreshDiv'])->name('bid.refresh-div');

Route::get('/refresh-price/{id}', [BidController::class, 'getHighestBidValue'])->name('bid.refresh-price');
//------------------------------------------------------------------------------------

//Section for image routes
//------------------------------------------------------------------------------------
//Route to show create image page
Route::get('/image/create/{id}', [ImageController::class, 'create'])->middleware(['auth','verified'])->name('image.create');
//momo
Route::get("/image/publication",function(){
    return to_route("index");
});
Route::get('/image/delete/{id}', [ImageController::class, 'deleteImage'])->middleware(['auth','verified'])->name('image.delete');
Route::get('/image/edit/{id}', [ImageController::class, 'edit_annonce'])->middleware(['auth','verified'])->name('image.edit');
Route::post('/image/edit/{id}', [ImageController::class, 'edit_annonce_recu'])->middleware(['auth','verified'])->name('image.update');
//Route to create the images (SAVE)
Route::post('/image', [ImageController::class, 'store'])->middleware(['auth','verified'])->name('image.store');
//------------------------------------------------------------------------------------

//Section for favoritePublicaitons routes
//------------------------------------------------------------------------------------
//Route to show create image page
Route::get('/publications/saved', [PublicationFollow::class, 'index'])->name('publicationfollow.index')->middleware(['auth','verified']);
//Route to store the follow on a publication
Route::get('publicationfollow/{id}/{show}', [PublicationFollow::class, 'store'])->name('publicationfollow.store')->middleware(['auth','verified']);
//Route to get the view of the followButton
Route::get('publicationfollow')->name('publications.followButton');
//------------------------------------------------------------------------------------
// Search by filter
Route::get('/publications/search',[PublicationController::class,'search']);
Route::get('/refresh-div', [BidController::class, 'refreshDiv']);
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
Route::get('/api/publications/fuelTypes',function ()
    {
        return PublicationResource::collection(Publication::all())->countBy('fuelType');
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
Route::get('/api/publications/maxYear',function ()
    {
        return PublicationResource::collection(Publication::all())->max('year');
    }
);
Route::get('/api/publications/minYear',function ()
    {
        return PublicationResource::collection(Publication::all())->min('year');
    }
);
// Route::get('/api/publications/kilometer',function ()
//     {
//         return PublicationResource::collection(Publication::all())->pluck('brand');
//     }
// );


// Bing map test
// Route::get('map',function() {
//     return view("map");
// });

// Get code postales
Route::get('/api/publications/postalcodes',function ()
    {
        $publications = Publication::all()->map(function ($pub){
            return ['id'=>$pub['id'],'postalcode'=>$pub['postalCode']];
        });
        return $publications;
    }
);
// Get newest publication
Route::get('/api/publications/newest',function ()
    {
        return Publication::all()->pluck('updated_at')->sortByDesc('updated_at')->first();
    }
);

// Route for getting last notifications
Route::get('/api/notifications',[NotificationController::class,"getUnsentNotifications"]
);

// admin
Route::group(['middleware'=>'admin'],function(){
    Route::get('/admin',[SignalementController::class,"index"]);
    Route::post('/admin',[SignalementController::class,"process"]);
    Route::get('admin/users',[UsersController::class,"getAll"]);
    Route::get('admin/users/list',[UsersController::class,"getUserList"]);
    Route::post('admin/user/block/{id}', [UsersController::class,"block"]);
    Route::post('admin/user/unblock/{id}', [UsersController::class,"unblock"]);
});

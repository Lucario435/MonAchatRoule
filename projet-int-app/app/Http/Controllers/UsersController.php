<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Image;
use App\Models\Publication;
use App\Models\rating;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

require_once "xnotifications.php";

class UsersController extends Controller
{
    public function __invoke()
    {
        return redirect("index");
    }

    public function index(Request $r, User $userid = null)
    {
        if ($userid != null) {
            return view("profil", ["userid" => $userid]);
        }
        return redirect("login");
    }
    public function login(){
        return view("login");
    }

    public function register()
    {
        return view("register");
    }

    public function store(StoreUserRequest $r)
    {
        $attributes = $r->validated();
        $attributes["userimage"] = "";
        $user = User::create($attributes);
        // event qui signale au mailsender un nouveau user vient de sinscrire
        if($user == null){return to_route("index");}
        event(new Registered($user));

        Auth::login($user);
        sendNotification($user->id,"Création de votre compte","Si vous voyez ce message, c'est que vous avez un compte prêt
        à l'utilisation. Bravo!","about");

        return $this->VerifierEmail(["name"=>$attributes['name'],"surname"=>$attributes['surname'],"email"=>$attributes['email'],"email_verified_now"=>0]);
    }
    public function destroySession($request){$request->session()->regenerate(false);}
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $errmsg = 'Email ou mot de passe invalide';
        if (Auth::attempt($credentials,true)) {
            $user = Auth::user();
            // echo $user;
            if($user->email_verified_at != null){
                $request->session()->regenerate();
                $request->session()->put('userid', $user["id"]);
                $request->session()->put('user', $user);
                $request->session()->put("loggedin",true);
                sendNotification($user->id,"Bienvenue sur le site!","Merci d'utiliser notre site pour trouver votre prochain véhicule. Bonne route!","about");

                return redirect()->intended('index');
            } else{$errmsg = "Veuillez vérifiez vos emails pour la confirmation du compte"; Auth::logout();}
            $request->session()->regenerate();
        }
        // request()->cookie('isConnectedMOMO',null);
        // setCookie("isConnectedMOMO",null,-1);

         $this->destroySession($request);
        return redirect()->back()->withErrors([
            'email' => $errmsg,
        ])->withInput($request->only('email'));
    }
    public function logout($request = null){
        Auth::logout();
        if($request != null)
            $this->destroySession($request);
        return to_route("index");
    }
    public function VerifierEmail($attributes = null)
    {
        if($attributes != null){
            //Auth::logout();
            return view("confirm-email",$attributes);
        }
        else
            return to_route('index');
    }
    public function userProfile(Request $request, $uid = null){
        if($uid == null)
            return to_route("index");
        if(User::find($uid) == null)
            return to_route("index");
        $plist = User::find($uid)->getPublications;
        $images = Image::all();
        $ratingsTemp = rating::all();
        $ratings = [];
        foreach ($ratingsTemp as $key => $value) {
            if($value->userid == $uid){
                $ratings[] = $value;
            }
        }
        return view("user",["uid" => $uid, "ratings"=>$ratings,"user" => User::find($uid), "publications" => $plist, "images" => $images]);
    }
    public function edit(Request $r){
        if(Auth::user() == null) return to_route("index");

        return view("editProfil",["user"=>Auth::user()]);
    }
    public function editPost(Request $request)
    {
        $user = Auth::user();
        if($user == null) return to_route("index");
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'userimage' => 'image|mimes:jpeg,png,jpg,gif|max:20000',
            'email_notification' => 'boolean'
        ]);

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->email_notification =
        $request->input("email_notification") == null ? false : $request->input("email_notification");

        if ($request->hasFile('userimage')) {
            $image = $request->file('userimage');
            $imageName = time().'.'.$image->extension();
            $public_path = '/images/resources/';

            $image->move(public_path($public_path), $imageName);

            if ($user->userimage) {
                Storage::delete($public_path . $user->userimage);
            }

            $user->userimage = $public_path.$imageName;
        }

        $user->save(); //il chiale encore

        return to_route("user.edit",["xalert"=>"Profil mis à jour avec succès!"]);
    }

}

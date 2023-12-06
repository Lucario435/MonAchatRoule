<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Image;
use App\Models\Publication;
use App\Models\rating;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\userrels;
use GuzzleHttp\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
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
    public function login()
    {
        if(User::find(Auth::id()))
            redirect(route('index'));
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
        $attributes["is_admin"] = 0;
        $attributes["is_blocked"] = 0;
        $user = User::create($attributes);
        // event qui signale au mailsender un nouveau user vient de sinscrire
        if ($user == null) {
            return to_route("index");
        }
        event(new Registered($user));

        Auth::login($user);
        sendNotification($user->id, "Création de votre compte", "Si vous voyez ce message, c'est que vous avez un compte prêt
        à l'utilisation. Bravo!", "about");

        return $this->VerifierEmail(["name" => $attributes['name'], "surname" => $attributes['surname'], "email" => $attributes['email'], "email_verified_now" => 0]);
    }
    public function destroySession($request)
    {
        $request->session()->regenerate(false);
    }
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $errmsg = 'Email ou mot de passe invalide';
        if (Auth::attempt($credentials, true)) {
            $user = Auth::user();
            // echo $user;
            if ($user->email_verified_at != null) {
                $request->session()->regenerate();
                $request->session()->put('userid', $user["id"]);
                $request->session()->put('user', $user);
                $request->session()->put("loggedin", true);
                if(!$user->is_blocked)
                    sendNotification($user->id, "Bienvenue sur le site!", "Merci d'utiliser notre site pour trouver votre prochain véhicule. Bonne route!", "about");

                return redirect()->intended('index');
            } else {
                $errmsg = "Veuillez vérifiez vos emails pour la confirmation du compte";
                Auth::logout();
            }
            $request->session()->regenerate();
        }
        // request()->cookie('isConnectedMOMO',null);
        // setCookie("isConnectedMOMO",null,-1);

        $this->destroySession($request);
        return redirect()->back()->withErrors([
            'email' => $errmsg,
        ])->withInput($request->only('email'));
    }
    public function logout($request = null)
    {
        Auth::logout();
        if ($request != null)
            $this->destroySession($request);
        return to_route("index");
    }
    public function VerifierEmail($attributes = null)
    {
        if ($attributes != null) {
            //Auth::logout();
            return view("confirm-email", $attributes);
        } else
            return to_route('index');
    }
    public function userProfile(Request $request, $uid = null)
    {
        if ($uid == null)
            return to_route("index");
        if (User::find($uid) == null)
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
        $phoneD = false;
        $usrls = userrels::all();
        foreach ($usrls as $key => $value) {
            if($value->reltype == "phoneD" && $value->user_sender == $uid){
                $phoneD = true;
            }
        }
        return view("user",["uid" => $uid,"phoneD"=>$phoneD, "ratings"=>$ratings,"user" => User::find($uid), "publications" => $plist, "images" => $images]);
    }
    public function edit(Request $r)
    {
        if (Auth::user() == null) return to_route("index");
        //save num telephone
        $usrls = userrels::all();
        $phoneD = false;
        foreach ($usrls as $key => $value) {
            if($value->reltype == "phoneD" && $value->user_sender == Auth::id()){
                $phoneD = true;
            }
        }
        return view("editProfil", ["user" => Auth::user(),"phoneDisplay"=>$phoneD]);
    }
    public function editPost(Request $request)
    {
        $user = Auth::user();
        if ($user == null) return to_route("index");
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'userimage' => 'image|mimes:jpeg,png,jpg,gif|max:20000',
            'email_notification' => 'boolean',
            'phone_display' => 'boolean'
        ]);

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->email_notification =
            $request->input("email_notification") == null ? false : $request->input("email_notification");

        if ($request->hasFile('userimage')) {
            $image = $request->file('userimage');
            $imageName = time() . '.' . $image->extension();
            $public_path = '/images/resources/';

            $image->move(public_path($public_path), $imageName);

            if ($user->userimage) {
                Storage::delete($public_path . $user->userimage);
            }
            $user->userimage = $public_path . $imageName;
        }

        $usrls = userrels::all();
        if($request->input("phone_display") == true){
            $attr = ["reltype"=>"phoneD", "user_sender"=>Auth::id(), "user_target"=>Auth::id()];
            $u = userrels::create($attr);
            if($u){
                $u->save();
            }
        } else{
            foreach ($usrls as $key => $value) {
                if($value->reltype == "phoneD" && $value->user_sender == Auth::id())
                    $value->delete();
            }
        }
        $user->save(); //il chiale encore

        return to_route("userProfile",["id"=>$user->id,"xalert"=>"Profil mis à jour avec succès!"]);
    }
    public function getAll(Request $request)
    {

        $users = User::all();
        // filter by blocked or not
        if ($request->query()) {
            $params = [];
            foreach ($request->query() as $key => $value) {
                $params = [$key, $value];
            }
            //dd($params);
            if ($params[1] != 'none')
                $users = $users->where($params[0], $params[1]);
            //dd($users);
            return view("admin.list-users", ['users' => $users]);
        }

        return view("admin.users-index", ['users' => $users]);
    }
    public function getUserList(){
        return view("admin.list-users",['users'=>User::all()]);
    }
    public function block($userid)
    {
        $user = User::find($userid);
        if ($user != null) {
            $user->is_blocked = 1;
            $user->save();
            return response()->json(['status' => 1]);
        } else
            return response()->json(['status' => 0]);
    }
    public function unblock($userid){
        $user = User::find($userid);
        if ($user != null) {
            $user->is_blocked = 0;
            $user->save();
            return response()->json(['status' => 1]);
        } else
            return response()->json(['status' => 0]);
    }
}

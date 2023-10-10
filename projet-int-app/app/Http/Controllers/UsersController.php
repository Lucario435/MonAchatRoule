<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


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
        return view("login");
    }
    public function register()
    {
        return view("register");
    }

    public function store(StoreUserRequest $r)
    {

        $attributes = $r->validated();

        $user = User::create($attributes);
        // event qui signale au mailsender un nouveau user vient de sinscrire
        event(new Registered($user));

        Auth::login($user);
        return $this->VerifierEmail(["name"=>$attributes['name'],"surname"=>$attributes['surname'],"email"=>$attributes['email'],"email_verified"=>0]);
    }
    public function destroySession($request){$request->session()->regenerate(false);}
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials,true)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $request->session()->put('userid', $user["id"]);
            $request->session()->put('user', $user);
            $request->session()->put("loggedin",true);
            return redirect()->intended('index');
        }
        // request()->cookie('isConnectedMOMO',null);
        // setCookie("isConnectedMOMO",null,-1);

        $this->destroySession($request);
        return redirect()->back()->withErrors([
            'email' => 'Email ou mot de passe invalide',
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
        if($attributes != null)
            return view("confirm-email",$attributes);
        else
            return to_route('index');
    }
    public function userProfile(Request $request, $uid = null){
        if($uid == null)
            return to_route("index");
        return view("user",["uid" => $uid, "user" => User::find($uid)]);
    }
}

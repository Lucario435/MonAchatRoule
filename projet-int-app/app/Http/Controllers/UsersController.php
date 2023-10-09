<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

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
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'Mauvaise combinaison de courriel et/ou de mot de passe',
        ])->onlyInput('email');
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
    public function VerifierEmail($attributes = null)
    {
        if($attributes != null)
            return view("confirm-email",$attributes);
        else
            return to_route('index');
    }
}

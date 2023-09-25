<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

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

    public function loginWData(Request $r)
    { //process

    }
    public function store(StoreUserRequest $r)
    {

        // Un input de type bool false doit etre initialisé ici, car le programme n'arrive pas a convertir la valeur false en bool depuis le form input bizzarement. Si depuis le form input une valeur de true est envoyé elle est bien interprété
        if ($r->input('email_notification') == null)
            $r->query->add(['email_notification' => false]);



        $attributes = $r->validated();

        //$attributes = $attributes->safe()->except(['password_confirm']);

        //dd(User::create($attributes));

        //return redirect('/confirm-email');
    }
    public function confirmEmail()
    {
        return view("confirm-email");
    }
}

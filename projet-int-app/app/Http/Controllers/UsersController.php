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
    public function store(StoreUserRequest $r) : RedirectResponse
    {

        $attributes = $r->validated();

        User::create($attributes);

        return redirect('/confirm-email'); // Passer le nom dans le view bag pour message 
    }
    public function confirmEmail()
    {
        return view("confirm-email");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class UsersController extends Controller
{
    public function __invoke(){return redirect("index");}

    public function index(Request $r, User $userid = null ){
        if($userid != null)
        { return view("profil",["userid" => $userid]);}
        return redirect("login");
    }
    public function login(){
        return view("login");
    }
    public function register(){
        return view("register");
    }

    public function loginWData(Request $r){ //process

    }
    public function store(Request $r){ //process l'inscription
        return (request()->all());

        
        // $attributes = request()->validate([
        //     'name' => 'required|max:255',
        //     'surname' => 'required|max:255',
        //     'username' => 'required|max:255|min:2',
        //     'phone' => 'required|max:255',
        //     'email' => 'required|email|max:255',
        //     'password' => 'required|min:7',
        //     'notification' => 'required|boolean',
        // ]);
        
        // if(!request('notification') != null)
        //     array_push($attributes,['password' => 'required|min:7']);


        //User::create($attributes);
    }
}

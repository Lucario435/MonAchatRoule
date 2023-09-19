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
    public function registerWData(Request $r){ //process l'inscription
        //echo var_dump($r);
        $email = $r->input("email");
        echo $email; // ca fonctionne!!!11 tlm de probleme a recuprer les inputs mais ca marhce finalement
    }
}

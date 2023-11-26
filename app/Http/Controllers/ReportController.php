<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Chatmessage;
use App\Models\Image;
use App\Models\notification;
use App\Models\Publication;
use App\Models\Signalement;
use App\Models\userrels;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class ReportController extends Controller
{
    //
    public function reportView(Request $r){
        if(Auth::user() == null) to_route("index");

        return view("report.create",["users" => User::all()]);
    }
    public function reportPost(Request $r){
        if(Auth::user() == null) to_route("index");
        // $sign = new Signalement();
        $attributes = [
            'user_sender' => Auth::id(),
            'user_target' => $r->input("user_target") == -1 ? null : $r->input("user_target") ,
            'status' => 0,
            'mcontent' => json_encode(["msg"=>$r->input("msg"), "hideText"=>$r->input("hideText")])
        ];
        $sign = Signalement::create($attributes);
        if($sign)
            return view("report.success");
        return to_route("report");
    }
}

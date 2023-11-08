<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Image;
use App\Models\notification;
use App\Models\Publication;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class NotificationController extends Controller
{
    public function index(){
        if(Auth::user() == null){return to_route("index");}
        $nlist = Auth::user()->getNotifications;

        return view("notifications",["nlist" => $nlist]);
    }
    public function click(Request $r, $nid){
        if(Auth::user() == null){return to_route("index");}
        $n = notification::find($nid);
        if($n == null){return to_route("index");}
        if($n->user != Auth::user()){return to_route("index");}

        $n->clicked = true;
        $n->save();
        return redirect($n->notificationLink);
    }
    public function delete(Request $r, $nid){
        if(Auth::user() == null){return to_route("index");}
        $n = notification::find($nid);
        if($n == null){return to_route("index");}
        if($n->user != Auth::user()){return to_route("index");}

        notification::where('id', $nid)->delete();

        return to_route("notifications",["xalert" => "Élément supprimé avec succès!"]);
    }
    public function multidelete(Request $r){ //a besoin de $nidtable dans post body
        if(Auth::user() == null){return to_route("index");}
        $nlist = Auth::user()->getNotifications;

        $nidtable = $r->input('nidtable', []);
        $numb = count($nidtable);
        foreach ($nlist as $inte => $n) {
            if(in_array($n->id, $nidtable)){
                notification::where("id",$n->id)->delete();
            }
        }

        return to_route("notifications",["xalert" => "$numb élément(s) supprimé(s) avec succès!"]);
    }
}

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
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Routing\ResponseFactory;

class NotificationController extends Controller
{
    public function index()
    {
        if (Auth::user() == null) {
            return to_route("index");
        }
        $nlist = Auth::user()->getNotifications->sortByDesc('created_at');

        $response = response()->view("notifications",["nlist" => $nlist]);

        // Set Cache-Control header
        $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');

        // Set Pragma header
        $response->header('Pragma', 'no-cache');

        // Set Expires header
        $response->header('Expires', '0');

        return $response;
    }
    public function click(Request $r, $nid)
    {
        if (Auth::user() == null) {
            return to_route("index");
        }
        $n = notification::find($nid);
        if ($n == null) {
            return to_route("index");
        }
        if ($n->user != Auth::user()) {
            return to_route("index");
        }

        $n->clicked = true;
        $n->save();
        return redirect($n->notificationLink);
    }
    public function delete(Request $r, $nid)
    {
        if (Auth::user() == null) {
            return to_route("index");
        }
        $n = notification::find($nid);
        if ($n == null) {
            return to_route("index");
        }
        if ($n->user != Auth::user()) {
            return to_route("index");
        }

        notification::where('id', $nid)->delete();

        return to_route("notifications", ["xalert" => "Élément supprimé avec succès!"]);
    }
    public function multidelete(Request $r)
    { //a besoin de $nidtable dans post body
        if (Auth::user() == null) {
            return to_route("index");
        }
        $nlist = Auth::user()->getNotifications;

        $nidtable = $r->input('nidtable', []);
        $numb = count($nidtable);
        foreach ($nlist as $inte => $n) {
            if (in_array($n->id, $nidtable)) {
                notification::where("id", $n->id)->delete();
            }
        }

        return to_route("notifications", ["xalert" => "$numb élément(s) supprimé(s) avec succès!"]);
    }
    public function getUnsentNotifications()
    {
        $user_id = Auth::id();
        $notifications = [0 => false];
        if ($user_id != null) {
            $requestNotifications = notification::all()->where("sent", '=', 0)->where("userid", '=', $user_id)->first();
            if ($requestNotifications != null) {
                // $notifications = notification::all()->where("sent",'=',0)->where("userid",'=',$user_id);
                $notifications[0] = $requestNotifications;
                // Set seen to 1 ... to stop from showing same notif
                $affected = DB::table('notifications')
                    ->where('sent', '=', 0)->where("userid", '=', $user_id)
                    ->where('id','=', $requestNotifications->id)
                    ->update(['sent' => 1]);


                return $notifications;
            }
            else{
                return false;
            }
        }
        return false;
    }
}

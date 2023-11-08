<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Chatmessage;
use App\Models\Image;
use App\Models\notification;
use App\Models\Publication;
use App\Models\userrels;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Mockery\Undefined;

require "xchatManager.php"; //contains chatgpt functions

class ChatController extends Controller
{
    public function index(Request $r, $id = null, $pid = null){
        if($id != null){
            if(User::find($id)->first() != null){
                $r->session()->put('cmselected', User::find($id));
            }
            //retourner la view mais faire en sorte que le user soit séléctionner directement meme si il n'y a pas d'anciens messages
        } else{$r->session()->put('cmselected', null);}
        if($pid != null){
            if(Publication::find($pid)->first() != null)
                $r->session()->put("msgpid",$pid);
        }
        return view("messagerie.index",["contacts" => getContacts(Auth::user())]);
    }
    public function get(Request $r, $id = null){
        if(Auth::user() == null){return to_route("index");}
        if($id == null){$id = $r->session()->get('cmselected', null);}
        if($id == null){return view("messagerie.noMessage", ["xmsg" => "Sélectionnez un contact!"]);}
        if(User::find($id) == null){return to_route("index");}
        $u1 = Auth::user();
        $u2 = User::find($id)->first();

        $conv = getConversation($u1,$u2);
        if(count($conv) == 0)
            return view("messagerie.noMessage",["u2" => $u2, "xmsg" => "Débutez votre conversation!"]);

        $seenConv = getConversationSideOfU1($u2,$u1);
        foreach($seenConv as $chat){
            $chat->seen = true;
            $chat->save();
        }
        // $conv = getConversation($u1,$u2);
        $pid = null;
        foreach ($conv as $key => $value) {
            if($value->publication_id != null)
                $pid = $value->publication_id;
        }
        $targetUserPString = null;
        if($pid != null){ //TRAVAILLER SUR CAAA 6:37 mercredi
            $ptitle = Publication::find($pid)->title;
            $targetUserPString = "<i>À propos de</i> ".$ptitle;
            // $targetUserPString = $u2->getPublicationsCountForDisplay();
        }
        // $targetUserPString = "<i>À propos de</i> "."salut";
        return view("messagerie.conversation",["conv" => $conv, "pid" => $pid, "targetUser" => $u2,"targetUserPString" => $targetUserPString]);
    }
    public function GetFriendsList(Request $r){
        if(Auth::user() == null) return to_route("index");
        $selected = $r->session()->get('cmselected', null);
        return view("messagerie.getfriendslist",["flist" => getContacts(Auth::user()), "selected" => $selected]);
    }
    public function SetCurrentTarget(Request $r){
        $userid = $r->input("userid");
        if(User::find($userid) == null){return ["error"];}
        $r->session()->put("cmselected",User::find($userid));
        return ["ok"];
    }
    public function send(Request $r){
        if($r->input("message") == null)
            return ["no message"];
        if($r->session()->get('cmselected', null) == null)
            return ["no target"];
        if(Auth::user() == null)
            return to_route("login");

        sendMessage(Auth::user(),$r->session()->get('cmselected', null)
        ,$r->input("message"),$r->session()->get("msgpid",null)); //ANNONCE ID
        return ["ok"];
    }
    public function userdelete(Request $r, $id){
        if(Auth::user() == null) return to_route("index");
        $chat = Chatmessage::find($id);
        if($chat == null)return to_route("index");
        if($chat->sender != Auth::user()) return to_route("index");
        $otheruser = getOtherUser($chat,Auth::user());
        $otherUserId = $otheruser->id;
        //$chat->delete();
        $chat->hidden = true;
        $chat->save();
        // $chat->save();
        return to_route("messageUser",["xalert" => "Message supprimé avec succès", "id" => $otherUserId]);
    }
    public function reportuser(Request $r, $id){
        return to_route("report",["hideText"=>"TargetUserId:$id"]);
    }
    public function blockUserMsgs(Request $r, $id) {
        // Check if the current user is authenticated
        if (Auth::user() == null) {
            return redirect()->route("index");
        }

        // Check if the user with the given ID exists
        $userToBlock = User::find($id);
        if ($userToBlock == null) {
            return redirect()->route("index");
        }

        // Check if the current user already has a 'blockmsg' relation with the target user
        $existingRelation = userrels::where([
            ['reltype', '=', 'blockmsg'],
            ['user_sender', '=', Auth::user()->id],
            ['user_target', '=', $userToBlock->id],
        ])->first();

        if ($existingRelation != null) {
            return redirect()->route("messages", ["xalert" => "Usagé déjà caché"]);
        }

        // Create a new 'blockmsg' relation
        userrels::create([
            'reltype' => 'blockmsg',
            'user_sender' => $userToBlock->id,
            'user_target' => Auth::user()->id
        ]);

        return redirect()->route("messages", ["xalert" => "L'usagé cible est dorénavant caché"]);
    }

}

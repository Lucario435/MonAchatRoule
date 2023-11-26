<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Chatmessage;
use App\Models\Image;
use App\Models\notification;
use App\Models\Publication;
use App\Models\rating;
use App\Models\userrels;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\vente;
use GuzzleHttp\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

require "xchatManager.php";
require "xnotifications.php";

class ChatController extends Controller
{
    public function index(Request $r, $id = null, $pid = null){
        if(Auth::user() == null){return to_route("index");}
        if($id != null){
            if(User::find($id)->first() != null){
                $r->session()->put('cmselected', User::find($id));
            }
            //retourner la view mais faire en sorte que le user soit séléctionner directement meme si il n'y a pas d'anciens messages
        } else{$r->session()->put('cmselected', null);}
        if($pid != null){
            if(Publication::find($pid) != null)
                $r->session()->put("msgpid",$pid);
        }
        return view("messagerie.index",["contacts" => getContacts(Auth::user())]);
    }
    public function messageUserFromPID(Request $r, $id, $pid = null){
        $noPid = is_null($pid);
        error_log("coucou");
        if(!$noPid)
            if(Publication::find($pid)->first() == null){
                $noPid = true;
                echo Publication::find($pid)->first();
            }

        if($noPid)
            return $this->index($r,$id);
        return $this->index($r,$id,$pid);
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
            return view("messagerie.noMessage",["u2" => $u2, "xmsg" => "Débutez votre conversation avec <i>" . $u2->getDisplayName(). "</i> !"]);

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
        $ahrefMarkBuyer = null;
        // if(Auth::user()->getPublicationsCountForDisplay() >0){
            // $ahrefMarkBuyer ='<a title="Marquer comme acheteur" style="color:var(--markBuyer); margin-left: .5rem;"href=\'{{ route("messages.markAsBuyer", ["uid" => $targetUser->id]) }}\'><i class="fa-solid fa-user-check"></i></a>';
        // }

        return view("messagerie.conversation",["conv" => $conv, "pid" => $pid, "ahrefMarkBuyer"=>$ahrefMarkBuyer, "targetUser" => $u2,"targetUserPString" => $targetUserPString]);
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
    public function notifUserBought(User $u, $v){
        sendNotification($u->id,"Évaluez votre achat!",
        "Félicitation pour votre achat! Il est temps d'évaluer votre expérience.",
        "/eval/". strval($v->seller_id) ."/" .strval($v->id));
    }
    public function markAsBuyer(Request $r,$uid){
        if(Auth::user() == null) return to_route("index");
        $targetUser = User::find($uid);
        if($targetUser == null) return to_route("index");
        //$targetUser = $targetUser->first();
        $connected = Auth::user();

        if(($connected->getPublicationsCountForDisplay()) == 1){
            $ps = $connected->getPublications;
            $p = null;
            foreach ($ps as $key => $value) {
                $p = $value;
            }
            if($p == null) return to_route("error",["xalert"=>"Problème"]);
            $v = vente::create(["userid"=>$targetUser->id,
            "seller_id" => Auth::id(), "publication_id"=>$p->id]);
            $p->update(['publicationStatus' => 'vendu']);
            $p->save();
            if($v != null){
                $this->notifUserBought($targetUser,$v);
            }
            return view("messagerie.markedAsBuyerSuccessful");
        }

        $publicationsAll = Auth::user()->getPublications;
        $publications = [];
        foreach ($publicationsAll as $key => $value) {
            if($value->publicationStatus != "vendu"){
                $publications[] = $value;
            }
        }
        return view("messagerie.markAsBuyer",["targetUser"=>$targetUser, "publications"=>$publications]);
    }
    public function rateSeller(Request $r,$uid,$vid){
        if(Auth::user() == null) return to_route("index");
        $targetUserSeller = User::find($uid);
        if($targetUserSeller == null) return to_route("index");
        $vs = vente::all();
        $v = null;
        foreach ($vs as $key => $vx) {
            if($vx->seller_id == $targetUserSeller->id && $vx->id == $vid){
                $v = $vx;
            }
        }
        $pid = $v->publication_id;
        return view("messagerie.rateSeller",["uid"=>$uid,"pid"=>$pid,"vid" => $vid]);
    }
    public function rateSellerEdit(Request $r, $rid){
        if(Auth::user() == null) return to_route("index",["xalert"=>"Connectez vous"]);
        $rat = rating::find($rid);
        if($rat == null) return to_route("index",["xalert"=>"Mauvais rating"]);
        $v = vente::find($rat->id);
        return view("messagerie.rateSellerEdit",["rid"=>$rid,"v"=>$v,"oldMsg"=>$rat->commentaire]);
    }
    public function rateSellerEditPost(Request $r){
        if(Auth::user() == null) return to_route("error");
        $rid =  $r->input("rid");
        if($rid == null) return to_route("error");
        $rat = rating::find($rid);
        if($rat == null) return to_route("error");

        if($r->input("rate"))
            $rat->etoiles = $r->input("rate");

        if($r->input("commentaire"))
            $rat->commentaire = $r->input("commentaire");
        $rat->save();
        return to_route("userProfile",["id"=>$rat->userid,"xalert"=>"Changement effectué avec succès"]);
    }
    public function rateSellerPost(Request $r){
        //vid, $v
        if(Auth::user() == null) return to_route("error");
        $vid = $r->input("vid");
        $msg = $r->input("commentaire");
        $et = $r->input("rate");
        $v = vente::find($vid);
        if($v == null) return to_route("error");
        if($msg == null) return to_route("error");
        if($et == null) return to_route("error");
        $usrrels = userrels::all();
        foreach ($usrrels as $key => $rel) {
            if($rel->reltype == "rated" && $rel->user_sender == Auth::id() && $rel->user_target == $v->seller_id)
                return to_route("notifications",["xalert"=>"Vous l'avez déjà évalué"]);
        }

        $usrrel = userrels::create(["reltype" => "rated", "user_sender"=> Auth::id(),
        "user_target" =>$v->seller_id]);
        $rating = null;
        if($usrrel != null){
            $rating = rating::create([
                "ventes_id" => $vid,
                "userid"=>$v->seller_id,
                "user_target"=>Auth::id(),
                "commentaire"=>$msg,
                "etoiles"=>$et,
                "publication_id"=>$v->publication_id
            ]);
            if($rating != null){
                return view("messagerie.rateSellerSuccess");
            }
        }
        if($usrrel != null)
            $usrrel->delete();

        if($rating != null)
            $rating->delete();

        return to_route("notifications",["xalert"=>"Votre évaluation n'a pas pu être sauvegardé"]);
    }
    public function rateSellerDelete(Request $r, $rid){
        if(Auth::user() == null) return to_route("error");
        if($rid == null) return to_route("error");
        $rat = rating::find($rid);
        if($rat == null) return to_route("error");

        $oldratuid = $rat->userid;

        $usrrels = userrels::all();
        $v = vente::find($rat->ventes_id);
        $relx = null;
        foreach ($usrrels as $key => $rel) {
            if($rel->reltype == "rated" && $rel->user_sender == Auth::id() && $rel->user_target == $v->seller_id)
                $relx = $rel;
            // return to_route("notifications",["xalert"=>"Vous l'avez déjà évalué"]);
        }
        if($relx != null){
            $relx->delete();
        }
        $rat->delete();
        return to_route("userProfile",["id"=>$oldratuid,"xalert"=>"L'évaluation a été supprimé avec succès"]);
    }
    public function markAsBuyerPost (Request $r){
        $uid = $r->input("uid");
        $pid = $r->input("pidVendu");
        if($uid == null) return to_route("error");
        if($pid == null) return to_route("error");
        if(Auth::user() == null) return to_route("error");
        $targetUser = User::find($uid);
        if($targetUser == null) return to_route("error");
        $connected = Auth::user();

        //targetUser, pid, connected
        $p = Publication::find($pid);
        if($p != null){
            $v = vente::create(["userid"=>$targetUser->id,
            "seller_id" => Auth::id(), "publication_id"=>$p->id]);
            $p->update(['publicationStatus' => 'vendu']);
            $p->save();
            if($v != null){
                notifUserBought($targetUser,$v);
            }
            return view("messagerie.markedAsBuyerSuccessful");
        }
        return to_route("index",["xalert"=>"Une erreur est survenue"]);
    }
    public function send(Request $r){
        if($r->input("message") == null)
            return ["no message"];
        if($r->session()->get('cmselected', null) == null)
            return ["no target"];
        if(Auth::user() == null)
            return to_route("login");
        $pidValue = $r->session()->pull("msgpid",null);
        sendMessage(Auth::user(),$r->session()->get('cmselected', null)
        ,$r->input("message"),$pidValue); //ANNONCE ID
        return ["ok"];
    }
    public function userdelete(Request $r, $id){
        if(Auth::user() == null) return to_route("error");
        $chat = Chatmessage::find($id);
        if($chat == null)return to_route("error");
        if($chat->sender != Auth::user()) return to_route("error");
        $otheruser = getOtherUser($chat,Auth::user());
        $otherUserId = $otheruser->id;
        //$chat->delete();
        $chat->hidden = true;
        $chat->save();
        // $chat->save();
        return to_route("messageUser",["xalert" => "Message supprimé avec succès", "id" => $otherUserId]);
    }
    public function reportuser(Request $r, $id){
        return to_route("report",["hideText"=>"TargetUserId:$id","usertarget"=>$id]);
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

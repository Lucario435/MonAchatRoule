<?php

namespace App\Http\Controllers;

use App\Models\Chatmessage;
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

function getContacts(User $user)
{
    $uid = $user->id;

    // Get all unique senders and receivers from messages
    $senders = Chatmessage::where('user_receiver', $uid)->distinct('user_sender')->pluck('user_sender');
    $receivers = Chatmessage::where('user_sender', $uid)->distinct('user_receiver')->pluck('user_receiver');

    // Merge and filter unique user IDs
    $contactUserIds = $senders->merge($receivers)->unique();

    // Exclude contacts where there is a 'blockmsg' relation
    $contacts = User::whereIn('id', $contactUserIds)
        ->whereDoesntHave('userRels', function ($query) use ($uid) {
            $query->where('reltype', 'blockmsg')
                ->where(function ($q) use ($uid) {
                    $q->where('user_sender', $uid)
                        ->orWhere('user_target', $uid);
                });
        })
        ->get();

    return $contacts;
}


function getConversationSideOfU1(User $user1, User $user2)
{
    $user1Id = $user1->id;
    $user2Id = $user2->id;

    // Get messages where user1 is the sender and user2 is the receiver
    $messagesFromUser1ToUser2 = Chatmessage::where('user_sender', $user1Id)
        ->where('user_receiver', $user2Id)
        ->orWhere(function ($query) use ($user1Id, $user2Id) {
            // Get messages where user2 is the sender and user1 is the receiver
            $query->where('user_sender', $user2Id)
                ->where('user_receiver', $user1Id);
        })
        ->orderBy('created_at', 'asc') // You can adjust the order of messages based on your requirement
        ->get();

    return $messagesFromUser1ToUser2;
}
function getConversation($user1,  $user2)
{
    $user1Id = $user1->id;
    $user2Id = $user2->id;

    // Get messages where user1 is the sender or receiver, and user2 is the sender or receiver
    $messages = Chatmessage::where(function ($query) use ($user1Id, $user2Id) {
        $query->where('user_sender', $user1Id)
            ->orWhere('user_receiver', $user1Id);
    })
        ->where(function ($query) use ($user1Id, $user2Id) {
            $query->where('user_sender', $user2Id)
                ->orWhere('user_receiver', $user2Id);
        })
        ->orderBy('created_at', 'asc') // You can adjust the order of messages based on your requirement
        ->get();

    $visibleMessages = [];
    foreach ($messages as $key => $msg) {
        if ($msg->hidden == false)
            $visibleMessages[] = $msg;
    }
    return $visibleMessages;
}
function sendMessage(User $sender, User $receiver, $msgChat, $pid = null)
{
    $message = new Chatmessage();
    $message->mcontent = $msgChat; //json_encode(["msg"=>$msgChat]);
    $message->user_sender = $sender->id;
    $message->user_receiver = $receiver->id;
    if (!is_null($pid))
        if (Publication::find($pid) != null)
            $message->publication_id = $pid;

    $message->seen = false;
    $message->hidden = false;
    $message->save();
    return $message;
}
function getOtherUser(Chatmessage $chat, $user)
{
    if ($chat->sender == $user) {
        return $chat->receiver;
    } else {
        return $chat->sender;
    }
}

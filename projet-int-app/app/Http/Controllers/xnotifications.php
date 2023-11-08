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

function sendNotification($userid,$title,$msg, $link){
    $attributes =
    ["userid" => $userid,
    "mcontent" => json_encode(["msg" => $msg, "title" => $title]),
    "notificationLink" => $link,
    "clicked" => false];

    $notif = notification::create($attributes);
    if($notif != null){
        return true;
    } return false;
}
function clearNotifications($userid){
    try {
        notification::where('userid', $userid)->delete();
        return true;
    } catch (\Exception $e) {
        return false;
    } return false;
}

?>

<?php

namespace App\Http\Controllers;


use App\Models\notification;


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
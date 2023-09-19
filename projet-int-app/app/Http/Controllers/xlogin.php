<?php

function getUID(){
    return session("userid");
}
function canLogin($userid,$pass){

}
function tryLogin($userid,$pass){
    if(canLogin($userid,$pass)){
        session()->put("userid",$userid); return true;
    } return false;
}

?>

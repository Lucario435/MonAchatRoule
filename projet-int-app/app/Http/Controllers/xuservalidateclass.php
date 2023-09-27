
<?php
function stringe(){return "";}
function usernamee(){return "";}

/*
PAS ENCORE FINI, il va servir
    à valider les users dans les controllers
    sant avoir a chequer manuellement.
    ex:
        a la place de:
        $user = User::find($userid);
        $user->displayname = "salut";
        if(... tout les checks)

        on fait:
        $user = User::find($userid);
        $xuser = new xuservalidate();
        $xuser->sdisplayname = "salut";
        $validé = $xuser->xvalidate();
        $user->save()
*/
class xuservalidateclass{
    public $email       = stringe();
    public $psw         = stringe();
    public $username    = usernamee();
    public $displayname = stringe();
    public $userimage   = stringe();

    public function xvalidate(){
        $v = true;
        if($email == ""){
            $v = false;
        }
        if($psw == ""){
            $v = false;
        }
        if ($username == ""){
            $v = false;
        } if($displayname == "")­{
            $v = false;
        } //ne pas avoir de userimage c good
        return $v;
    }
}

?>

<?php

namespace App\Observers;

use App\Mail\PublicationChanged;
use App\Models\Publication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers;
use App\Http\Controllers\NotificationClass;

require_once 'xnotifications.php';
//echo app_path('Http\Controllers\xnotifications.php');

class PublicationObserver
{
    /**
     * Handle the Publication "created" event.
     */
    const eqTableFrench = [
        "title"=>'titre',
        "bodyType"=>'Type de carroserie',
        "brand"=>'Marque',
        "color"=>'Couleur de peinture',
        "expirationOfBid"=>"Date d'échéance de l'enchère",
        "fixedPrice"=>'Prix',
        "fuelType"=>'Type de carburant',
        "kilometer"=>'Kilomètrage',
        "postalCode"=>'Code postal',
        "year"=>'Année',
        "type"=>"Type d'annonce",
        "description"=>"description"
    ];
    public function created(Publication $publication): void
    {
        //
    }

    /**
     * Handle the Publication "updated" event.
     */
    public function updated(Publication $publication): void
    {
        // Sql request pour voir si la publication a des suiveurs
        $subscribersEmail = DB::table('suiviannonces')
            ->join('publications', 'suiviannonces.publication_id', '=', 'publications.id')
            ->join('users', 'users.id', '=', 'suiviannonces.userid')
            ->where('publications.id', '=', $publication->id)
            ->select('suiviannonces.userid', 'suiviannonces.publication_id', 'publications.title', 'users.email', 'users.username')->get(); 

        $oldAttributes = $publication->getOriginal();
        $newAttributes = $publication->getDirty();
    
        $changedAttributesWithText = [];
        $string = "";
        foreach ($newAttributes as $attribute => $newValue) {
            $oldValue = $oldAttributes[$attribute];
            
            // $enFrancais = isset(self::eqTableFrench[$attribute]) ? self::eqTableFrench[$attribute] : $attribute;
            if(isset(self::eqTableFrench[$attribute])){
                $enFrancais = self::eqTableFrench[$attribute];
                if($enFrancais == 'description'){
                    $changedAttributesWithText[] = "$enFrancais à changée";
                    $string .= "$enFrancais a changée <br>";
                }
                else if($enFrancais == "Type d'annonce"){
                    $toSend = $newValue == 1 ? "L'annonce est devenue une enchère. " : "L'annonce n'est plus une enchère. ";
                    $changedAttributesWithText[] = $toSend;
                    $string .= '<b>'.$toSend.'</b>';
                }
                else{
                    $changedAttributesWithText[] = "$enFrancais est passé de '$oldValue' à '$newValue'";
                    $string .= "$enFrancais a changé<br>";
                }
            }
            
        }

        foreach ($subscribersEmail as $sub) {
            //dd($sub->email);
            Mail::to($sub->email)->queue(new PublicationChanged($publication,$changedAttributesWithText));
            // Test sendNotification when done
            sendNotification(
                $sub->userid,
                $publication->title,
                $string,
                url("publication/detail/{$publication->id}")
            );
        }
    }

    /**
     * Handle the Publication "deleted" event.
     */
    public function deleted(Publication $publication): void
    {
        //
    }

    /**
     * Handle the Publication "restored" event.
     */
    public function restored(Publication $publication): void
    {
        //
    }

    /**
     * Handle the Publication "force deleted" event.
     */
    public function forceDeleted(Publication $publication): void
    {
        //
    }
}

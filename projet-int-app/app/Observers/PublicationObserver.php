<?php

namespace App\Observers;

use App\Mail\PublicationChanged;
use App\Models\Publication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

//require_once 'xnotifications.php';

class PublicationObserver
{
    /**
     * Handle the Publication "created" event.
     */
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
        $subscribers_email = DB::table('suiviannonces')
            ->join('publications', 'suiviannonces.publication_id', '=', 'publications.id')
            ->join('users', 'users.id', '=', 'suiviannonces.userid')
            ->where('publications.id', '=', $publication->id)
            ->select('suiviannonces.userid', 'suiviannonces.publication_id', 'publications.title', 'users.email', 'users.username')->get(); 

        foreach ($subscribers_email as $sub) {
            //dd($sub->email);
            Mail::to($sub->email)->queue(new PublicationChanged($publication));
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

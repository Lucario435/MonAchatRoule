<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Publication;
use App\Models\Suiviannonce;
use Illuminate\Support\Facades\Auth;

class PublicationFollow extends Controller
{
    //Returns the main publications page and the object "publication" so we can get it and show it in the page
    public function index(){
        $publications = Publication::all();
        $followedPublications = Suiviannonce::all();

        $currentUser = Auth::user("id");

        $followedPublicationsId = null;

        $publicationsAllFiltered = [];

        //Returns all the id and save it in the followedPublicationsId
        foreach($followedPublications as $followed)
        {
            if($followed->user_id == $currentUser)
            {
                $followedPublicationsId += $followed->id;
            }
        }

        //Returns all the publications that has the same id of followedPublicationsId
        foreach($publications as $publication)
        {
            foreach($followedPublicationsId as $follow)
            {
                if($publication->id == $follow)
                {   
                    $publicationsAllFiltered += $publication;
                }
            }
        }

        return view('publicationfollow.index', ['publications' => $publicationsAllFiltered]);
    }
}

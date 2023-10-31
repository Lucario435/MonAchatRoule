<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Publication;
use App\Models\Suiviannonce;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class PublicationFollow extends Controller
{
    //Returns the main publications page and the object "publication" so we can get it and show it in the page
    public function index()
    {
        $publications = Publication::all();
        $followedPublications = Suiviannonce::all();

        $currentUser = Auth::id();

        $followedPublicationsId = [];

        $publicationsAllFiltered = [];

        //Returns all the id and save it in the followedPublicationsId
        foreach ($followedPublications as $followed) {
            if ($followed->userid == $currentUser) {
                array_push($followedPublicationsId, $followed->publication_id);
            }
        }
        //Returns all the publications that has the same id of followedPublicationsId
        foreach ($publications as $publication) {
            foreach ($followedPublicationsId as $follow) {
                if ($publication->id == $follow) {
                    array_push($publicationsAllFiltered,$publication);
                }
            }
        }
        $images = Image::all();
        return view('publicationfollow.index', ['publications' => $publicationsAllFiltered], ['images' => $images]);
    }

    //Inserts a publication into database (needs to pass validation tests before insertion)
    public function store(Request $request)
    {
        $data = $request->validate([
            //publication validation
            'publication_id' => 'required',
        ]);
        $publication = Publication::find($data['publication_id']);
        $suiviannonces = Suiviannonce::all();
        //Does the publication exists
        if($publication != null)
        {
            $currentUser = Auth::id();
            
            //Does the user exists
            if ($currentUser != null) {
                //Does the user already has saved this publication
                foreach($suiviannonces as $suivi)
                {
                    if($suivi->userid == $currentUser && $suivi->publication_id == $data['publication_id'])
                    {
                        $suivi->delete();
                        return redirect()->route('publication.detail', ['id' => $data['publication_id']])->with('message', 'Publication retiré des annonces suivies!');
                    }
                }
                $data['userid'] = $currentUser;
                //Insertion
                $newPublicationFollow = suiviannonce::create($data);

                //Redirect to index page
                return redirect()->route('publication.detail', ['id' => $data['publication_id']])->with('message', 'Publication ajouté aux annonces suivies!');
            }
        }
    }
}

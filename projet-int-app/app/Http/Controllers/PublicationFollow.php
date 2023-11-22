<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Publication;
use App\Models\Suiviannonce;
use App\Models\Image;
use Illuminate\Console\View\Components\Warn;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

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
    public function store($id, $show)
    {   
        $publication = Publication::find($id);
        $suiviannonces = Suiviannonce::all();
        if($show == 'true')
        {
            error_log('wow');
            //Does the publication exists
            if($publication != null)
            {
                $currentUser = Auth::id();
                
                //Does the user exists
                if ($currentUser != null) {
                    //Does the user already has saved this publication
                    foreach($suiviannonces as $suivi)
                    {
                        if($suivi->userid == $currentUser && $suivi->publication_id == $id)
                        {
                            return view('publications.followButton', ['followed' => true]);
                            //return redirect()->route('publication.detail', ['id' => $id])->with('message', 'Publication retiré des annonces suivies!');
                        }
                    }
                    return view('publications.followButton', ['followed' => false]);
                }
            }
        }
        //Does the publication exists
        if($publication != null && $show == 'false')
        {
            $currentUser = Auth::id();
            
            //Does the user exists
            if ($currentUser != null) {
                //Does the user already has saved this publication
                foreach($suiviannonces as $suivi)
                {
                    if($suivi->userid == $currentUser && $suivi->publication_id == $id)
                    {
                        $suivi->delete();
                        return view('publications.followButton',['followed' => false])->with('message', 'Publication retiré des annonces suivies!');
                        //return redirect()->route('publication.detail', ['id' => $id])->with('message', 'Publication retiré des annonces suivies!');
                    }
                }
                $data['publication_id'] = $id;
                $data['userid'] = $currentUser;
                //Insertion
                $newPublicationFollow = suiviannonce::create($data);
                return view('publications.followButton',['followed' => true])->with('message', 'Publication ajouté des annonces suivies!');
            }
            else
            {
                return redirect(route('login'))->with('message', 'Il faut être connecté pour effectuer cette action!');
            }
        }
        else
        {
            return redirect(route('publication.index'))->with('message', 'Cette annonce existe plus!');
        }
    }
}

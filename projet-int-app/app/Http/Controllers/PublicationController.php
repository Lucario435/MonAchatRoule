<?php

namespace App\Http\Controllers;

//Supports auth
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

//Models are a must to access database since Controller <=> Model <=> DB
use App\Models\Publication;
use App\Models\Image;

//require_once 'xlogin.php';


class PublicationController extends Controller
{
    //Returns the main publications page and the object "publication" so we can get it and show it in the page
    public function index(){
        $publications = Publication::all();
        $images = Image::all();
        return view('publications.index', ['publications' => $publications,'images' => $images]);
    }

    //Returns the create publication page
    public function create(){
        return view('publications.create');
    }

    //Inserts a publication into database (needs to pass validation tests before insertion)
    public function store(Request $request){
        //Validation /////////To Do Jonathan : More validation
        $data = $request->validate([
            //publication validation
            'title' => 'required',
            'description' => 'nullable',
            'type' => 'required',
            'hidden' => 'required',
            'expirationOfBid' => 'nullable',
            'postalCode' => 'required',
            //'publicationStatus' => 'required',

            //By default, if we will need to show car details it will only say "Not specified by owner"
            //car validation
            'fixedPrice' => 'required|numeric', //ex : 0.00
            'kilometer' => 'nullable|numeric',
            'bodyType' => 'nullable',
            'transmission' => 'nullable',
            'brand' => 'nullable',
            'color' => 'nullable'

        ]);
        //Validation of the user ID
        /*
        if(null != getUID())
        {
            $data['user_id'] = getUID();
        }

        //Si l'utilisateur n'est pas connecté, on redirige vers la page connexion

        ///////////////////////////////////////////////////////////////////////////////
        //Remettre cette ligne après les test
        /*else{
            return redirect(route('login'));
        }*/

        //Temporairement, c'est le id 1 qui publie les annonces à effacer quand le login fonctionnera
        //else{
            $data['user_id'] = Auth::id();
        //}

        //The default status of the publication will be "ok"
        $data['publicationStatus'] = 'ok';

        ///////////////////////////////////////////////////////////////////////////////
        //Insertion
        $newPublication = Publication::create($data);

        //Redirect to index page
        //!!! In the future, the route will redirect to "mes annonces" or the page "détail" and the user will be able to see it on top of the list
        return redirect(route('image.create'))->with('message', 'Publication créé avec succès!');
    }
    public function viewupdate(Request $r, $pid){
        $p = Publication::find($pid);
        if($p == null){return to_route("index");}
        if($p->user_id != Auth::id()){return to_route("index");}
        return view('publications.create',["isEdit" => true, "pid" => $pid, "publication" => $p]);
    }
    public function update(Request $request, $id){ //post
        $p = Publication::find($id);
        if($p == null){return to_route("index");}
        if($p->user_id != Auth::id()){return to_route("index");}
        $data = $request->validate([
            //publication validation
            'title' => 'required',
            'description' => 'nullable',
            'type' => 'required',
            'hidden' => 'required',
            'expirationOfBid' => 'nullable',
            'postalCode' => 'required',
            'fixedPrice' => 'required|numeric', //ex : 0.00
            'kilometer' => 'nullable|numeric',
            'bodyType' => 'nullable',
            'transmission' => 'nullable',
            'brand' => 'nullable',
            'color' => 'nullable'
        ]);

        // Find the publication by ID
        $publication = Publication::find($id);

        // Check if the publication exists
        if (!$publication) {
            // Handle the case where the publication is not found, e.g., show an error message or redirect back
            return redirect()->back()->with('error', 'Publication not found!');
        }
        $data["user_id"] = Auth::id();
        // Update the publication with the validated data
        $publication->update($data);
        return redirect(route('image.edit',["id" => $publication->id]))->with('message', 'Publication mise à jour avec succès!');
    }
}

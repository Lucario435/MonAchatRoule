<?php

namespace App\Http\Controllers;

//Supports auth
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//Models are a must to access database since Controller <=> Model <=> DB
use App\Models\Publication;
use App\Models\Suiviannonce;
use App\Models\Image;
use App\Models\Bid;
use App\Models\User;
use Hamcrest\Type\IsNumeric;
use Illuminate\Database\Eloquent\Casts\Json;
use Mockery\Undefined;

use function Laravel\Prompts\error;

class PublicationController extends Controller
{
    //Returns the main publications page and the object "publication" so we can get it and show it in the page
    public function index()
    {
        $publications = Publication::all();
        $images = Image::all();
        return view('publications.index', ['publications' => $publications, 'images' => $images]);
    }
    public function delete($id)
    {
        $publicationExist = Publication::where('id', $id)->first();
        //Vérifier si l'annonce existe
        if($publicationExist != null)
        {
            //Vérifier que l'annonce est à nous et que nous sommes connecté
            $currentUser = Auth::id();
            if($currentUser != null && $currentUser == $publicationExist->user_id)
            {
                //Vérifier si des enchères ont été mis sur l'annonce
                $publicationBids = Bid::where('publication_id', $id)->get();
                if(count($publicationBids) == 0)
                {
                    DB::table('publications')->delete($id);
                    return redirect(route('publication.index'))->with('message', 'Votre annonce a été supprimée!');
                }
                else
                {
                    //Redirige vers la page détail
                    return redirect(route('publication.detail', ['id' => $id]))->with('message', 'Votre annonce comporte des enchères et ne peut pas être supprimé!');
                }
            }
            else
            {
                //Redirige vers la page détail
                return redirect(route('publication.detail', ['id' => $id]))->with('message', 'Il faut être connecté et être propriétaire de cette annonce pour la supprimer!');
            }
        }
        else
        {
             //Redirige vers la page index
             return redirect(route('publication.index'))->with('message', 'Cette annonce n\'existe pas!');
        }
    }
    //Returns the detail page of a publication and it's values images are taken only in the html in a foreach
    public function detail($id)
    {
        $publicationExist = Publication::find($id);

        $currentUser = Auth::id();
        //Vérifier que l'annonce est privée, on redirige vers l'index
        if($publicationExist->hidden == 1 || $currentUser == $publicationExist->user_id)
        {
            $followedPublications = Suiviannonce::where('publication_id', $id)->first();

            $publicationBids = Bid::where('publication_id',$id)->get();


            $followed = false;

            //Returns true if id current user has saved this publication
            if($followedPublications != null && $currentUser != null)
            {
                if ($followedPublications->userid == $currentUser && $followedPublications->publication_id == $id) {
                    $followed = true;
                }
            }

            $publication = Publication::find($id);
            $images = Image::all();

            if (!$publication) {
                abort(404); // Handle the case when the item is not found.
            }

            $images = Image::where('publication_id', $publication->id)->get();

            return view('publications.detail', ['publication' => $publication, 'images' => $images, 'followed' => $followed,'bids' => $publicationBids]);
        }
        else
        {
            return redirect(route('publication.index'))->with('message', 'Cette annonce est privée!');
        }
    }

    //Returns the create publication page
    public function create()
    {
        return view('publications.create');
    }

    //Inserts a publication into database (needs to pass validation tests before insertion)
    public function store(Request $request)
    {
        //Validation /////////To Do Jonathan : More validation
        $data = $request->validate([
            //publication validation
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
            'hidden' => 'required',
            'expirationOfBid' => 'nullable',
            'postalCode' => 'required',
            //'publicationStatus' => 'required',

            //By default, if we will need to show car details it will only say "Not specified by owner"
            //car validation
            'fuelType' => 'required',
            'year' => 'required|numeric',
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

        //Temporairement, c'est le id 1 qui publie les annonces à effacer quand le login fdonctionnera
        //else{
        $data['user_id'] = Auth::id();
        //}

        //The default status of the publication will be "ok"
        $data['publicationStatus'] = 'En vente';

        ///////////////////////////////////////////////////////////////////////////////
        //Insertion
        
        $newPublication = Publication::create($data);

        //Redirect to index page
        //!!! In the future, the route will redirect to "mes annonces" or the page "détail" and the user will be able to see it on top of the list
        return redirect(route('image.create',["id"=>$newPublication->id]))->with('message', 'Publication créé avec succès!');
    }
    public function viewupdate(Request $r, $pid)
    {
        $p = Publication::find($pid);
        if ($p == null) {
            return redirect(route('publication.index'))->with('message', "Cette annonce n'existe pas!");
        }
        if ( $p->user_id != Auth::id() && !User::find(Auth::id())->isAdmin()  ) {
            return redirect(route('publication.index'))->with('message', "Vous n'avez pas accès à cette page!");
        }
        return view('publications.create', ["isEdit" => true, "pid" => $pid, "publication" => $p]);
    }
    public function update(Request $request, $id)
    { //post
        $p = Publication::find($id);
        if ($p == null) {
            return redirect(route('publication.index'))->with('message', "Cette annonce n'existe pas!");
        }
        if ( $p->user_id != Auth::id()) {
            if(!User::find(Auth::id())->isAdmin()){
                return redirect(route('publication.index'))->with('message', "Vous n'avez pas l'autorisation de modifier cette annonce!");
            }
        }
        $data = $request->validate([
            //publication validation
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
            'hidden' => 'required',
            'fuelType' => 'required',
            'year' => 'required|numeric',
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
            // Handle the case where the publication is not found
            return redirect()->back()->with('error', 'Publication introuvable.');
        }
        $data["user_id"] = Auth::id();
        // Update the publication with the validated data
        $publication->update($data);
        return redirect(route('image.edit', ["id" => $publication->id]))->with('message', 'Publication mise à jour avec succès!');
    }

    public function search(Request $request)
    {

        $params = $request->query();
        $orderByCommand = "order";
        $eqTable = [
            "orderMileage" => "kilometer",
            "orderPrice" => "fixedPrice",
            "orderDateAdded" => "created_at",
            "orderDistance" => "distance",
        ];
        $filteringCriterias = [];
        $orderByRequest = [];
        $order = "";
        $userCoordinates = '';
        $boolRequestDistances = false;
        $boolFollowedPublications = false;

        foreach ($params as $key => $item) {
            //dd($item);   
            if (substr($key, 0, 5) == $orderByCommand) {
                $orderByRequest[$eqTable[$key]] = explode(',', $item);
                $order = $eqTable[$key];
                if ($order == "distance") {
                    $temp = explode(',', $item);
                    $userCoordinates = $temp[1] . ',' . $temp[2];
                    $boolRequestDistances = true;
                }
            } else {
                //dd($key);
                if (strtolower($key) == "followedpublications") {
                    $boolFollowedPublications = true;
                } else {
                    $filteringCriterias[$key] = explode(',', $item);
                }
            }
        }

        $sortingCriterias = [];
        foreach ($orderByRequest as $column => $data) {
            $sortingCriterias[] = [$column, $data[0]];
        }

        // Remove tha last virgule causing sql problem
        //strlen($orderByRequest) == 0 ? $orderByRequest = "created_at ASC" : $orderByRequest = rtrim($orderByRequest, ', ');;

        DB::enableQueryLog();
        if (count($filteringCriterias) > 0) {
            //dd($filteringCriterias);
            $publications = $this->getFilteredPublications($filteringCriterias);
            //dd($publications,DB::getQueryLog());
            
            if ($boolRequestDistances) {

                foreach ($publications as $key => $value) {
                    //dd($publications->$key);
                    $postalCode = preg_replace('/\s+/', '', $publications[$key]->postalCode);
                    $publications[$key]->distance = $this->getTravelDistance($userCoordinates, $postalCode);
                }
            }

            $publications = $publications->sortBy($sortingCriterias);
            $images = DB::table("images")->get();
            //dd($publications);
        } else {
            if ($boolFollowedPublications) {
                $publications = DB::table('publications')
                    ->join('suiviannonces', 'suiviannonces.publication_id', '=', 'publications.id')
                    ->where('suiviannonces.userid','=',Auth::id())
                    ->select('publications.*')
                    ->get();
                //dd($publications);
                $images = DB::table("images")   
                ->join('publications', 'images.publication_id', '=', 'publications.id')
                ->join('suiviannonces', 'suiviannonces.publication_id', '=', 'publications.id')
                ->select(['images.id','images.publication_id','images.user_id','images.url'])
                ->get();
                //dd(DB::getQueryLog());
                //dd($images);
            } else {
                $publications = DB::table('publications')->get();
                $images = Image::all();
            }

            //If we do have distance in query params, then we add the calculated distance in order to use later

            if ($boolRequestDistances) {


                foreach ($publications as $key => $value) {
                    //dd($publications->$key);
                    $postalCode = preg_replace('/\s+/', '', $publications[$key]->postalCode);
                    $publications[$key]->distance = round($this->getTravelDistance($userCoordinates, $postalCode),2);
                }
            }


            $publications = $publications->sortBy(
                $sortingCriterias
            );

            //dd(DB::getQueryLog());

        }

        

        //dd($publications);

        return view('publications.carte', ['publications' => $publications, 'images' => $images]);
    }
    private function getFilteredPublications($filteringCriterias)
    {
        // Inspired by this source
        // https://stackoverflow.com/q/61479114
        return DB::table('publications')->where(
            function ($query) use ($filteringCriterias) {
                foreach ($filteringCriterias as $key => $item) {
                    $query->where(
                        function ($query) use ($item, $key) {
                            foreach ($item as $value) {
                                //dd($key,$item);
                                if ($key == "minPrice")
                                    $query->Where("fixedPrice", '>=', ($value));

                                else if ($key == "maxPrice")
                                    $query->Where("fixedPrice", '<=', ($value));

                                else if ($key == "minMileage")
                                    $query->Where("kilometer", '>=', ($value));

                                else if ($key == "maxMileage")
                                    $query->Where("kilometer", '<=', ($value));
                                
                                else if ($key == "minYear")
                                    $query->Where("year", '>=', intval($value));
                                
                                else if ($key == "maxYear")
                                    $query->Where("year", '<=', intval($value));
                                
                                else if ($key == "title")
                                    $query->Where("title", 'like', "%$value%");

                                else {
                                    ///dd(DB::getQueryLog());
                                    $query->orWhere($key, '=',  str_replace(',', ' ', $value));
                                }
                            }
                        }
                    );
                }
            }
        )->get();
    }
    public function markAsSold($id)
    {
        $publication = Publication::find($id);

        $publication->update(['publicationStatus' => 'vendu']);

        return redirect(route('publication.detail', ['id' => $id]))->with('message', 'Votre annonce ' . $publication->title . ' s\'est vendu!');
    }
    private function getTravelDistance($wp1, $wp2)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://dev.virtualearth.net/REST/V1/Routes/Driving?o=json&wp.0=$wp1&wp.1=$wp2&key=AtND6We4q6ydLy0dVPwZ1NGD__tCGQzhVSIhMA4EQnSTMVgtOg9TwWhOYzYvVzVC",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        //dd($curl);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        //dd($curl);
        if ($err) {
            return ("cURL Error #:" . $err);
        } else {

            // if($res == null)
            //     dd("address is not valid");
            // else
            //     return $res;
            try {
                $res = json_decode($response)->resourceSets[0]->resources[0]->travelDistance;
                return $res;
            } catch (\Throwable $th) {
                return false;
                // return "proximité: inconnue";
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

//Supports auth
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//Models are a must to access database since Controller <=> Model <=> DB
use App\Models\Publication;
use App\Models\suiviannonce;
use App\Models\Image;
use Hamcrest\Type\IsNumeric;
use Illuminate\Database\Eloquent\Casts\Json;
use Mockery\Undefined;

class PublicationController extends Controller
{
    //Returns the main publications page and the object "publication" so we can get it and show it in the page
    public function index()
    {
        $publications = Publication::all();
        $images = Image::all();
        return view('publications.index', ['publications' => $publications, 'images' => $images]);
    }

    //Returns the detail page of a publication and it's values images are taken only in the html in a foreach
    public function detail($id)
    {
        $followedPublications = Suiviannonce::where('publication_id', $id)->first();

        $currentUser = Auth::id();

        $followed = false;

        //Returns true if id current user has saved this publication
        if ($followedPublications != null && $currentUser != null) {
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

        return view('publications.detail', ['publication' => $publication, 'images' => $images, 'followed' => $followed]);
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
    public function viewupdate(Request $r, $pid)
    {
        $p = Publication::find($pid);
        if ($p == null) {
            return to_route("index");
        }
        if ($p->user_id != Auth::id()) {
            return to_route("index");
        }
        return view('publications.create', ["isEdit" => true, "pid" => $pid, "publication" => $p]);
    }
    public function update(Request $request, $id)
    { //post
        $p = Publication::find($id);
        if ($p == null) {
            return to_route("index");
        }
        if ($p->user_id != Auth::id()) {
            return to_route("index");
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
            // Handle the case where the publication is not found, e.g., show an error message or redirect back
            return redirect()->back()->with('error', 'Publication not found!');
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
            $publications = $this->getFilteredPublications($filteringCriterias);

            if ($boolRequestDistances) {

                foreach ($publications as $key => $value) {
                    //dd($publications->$key);
                    $postalCode = preg_replace('/\s+/', '', $publications[$key]->postalCode);
                    $publications[$key]->distance = $this->getTravelDistance($userCoordinates, $postalCode);
                }
            }

            $publications = $publications->sortBy($sortingCriterias);
            //dd($publications);
        } else {
            if ($boolFollowedPublications) {
                $publications = DB::table('publications')
                    ->join('suiviannonces', 'suiviannonces.publication_id', '=', 'publications.id')
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
                    $publications[$key]->distance = $this->getTravelDistance($userCoordinates, $postalCode);
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
                                if ($key == "minPrice")
                                    $query->Where("fixedPrice", '>=', ($value));
                                else if ($key == "maxPrice")
                                    $query->Where("fixedPrice", '<=', ($value));
                                else if ($key == "minMileage")
                                    $query->Where("kilometer", '>=', ($value));
                                else if ($key == "maxMileage")
                                    $query->Where("kilometer", '<=', ($value));
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

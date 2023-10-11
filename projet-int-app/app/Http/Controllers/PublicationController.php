<?php

namespace App\Http\Controllers;

//Supports auth
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//Models are a must to access database since Controller <=> Model <=> DB
use App\Models\Publication;
use App\Models\Image;
use Hamcrest\Type\IsNumeric;
use Illuminate\Database\Eloquent\Casts\Json;



class PublicationController extends Controller
{
    //Returns the main publications page and the object "publication" so we can get it and show it in the page
    public function index()
    {
        $publications = Publication::all();
        $images = Image::all();
        return view('publications.index', ['publications' => $publications, 'images' => $images]);
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
        $data['user_id'] = 14;
        //}

        //The default status of the publication will be "ok"
        $data['publicationStatus'] = 'ok';

        ///////////////////////////////////////////////////////////////////////////////
        //Insertion
        $newPublication = Publication::create($data);

        //Redirect to index page
        //!!! In the future, the route will redirect to "mes annonces" or the page "détail" and the user will be able to see it on top of the list
        return redirect(route('image.create'))->with('message', 'Publication créée avec succès!');
    }

    public function search(Request $request)
    {
        // Inspired by this source
        // https://stackoverflow.com/q/61479114
        $params = $request->query();

        $tab = array();
        foreach ($params as $key => $item) {
            $tab[$key] = explode(',', $item);
        }

        //dd(count($tab));
        if (count($tab) > 0) {
            // $publications = Publication::where(
            //     function ($query) use ($tab) {
            //     foreach($tab as $key => $item) {
            //         //dd($key);
            //         foreach ($item as $value) {
            //             $query->orWhere($key, '=',  str_replace(',',' ',$value));
            //         }
            //         // Checks if we still can do AND operator between different keys until there is no more key
            //         // if(count($tab) > 0 && end($tab) != $tab[count($tab)-1]){
            //         //     $query->Where();
            //         // }
            //     }
            //     dd($query->toSql());
            // })->get();
            DB::enableQueryLog();
            $publications = DB::table('publications')->where(
                function ($query) use ($tab) {
                    foreach ($tab as $key => $item) {
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
                                    else
                                        $query->orWhere($key, '=',  str_replace(',', ' ', $value));
                                }
                            }
                        );
                    }
                    //dd($query->toSql());
                }
            )->get();

            //dd(DB::getQueryLog());
            //dd

            $images = Image::all();
        } else {
            //dd("enter else");
            $publications = Publication::all();
            $images = Image::all();
        }

        return view('publications.carte', ['publications' => $publications, 'images' => $images]);
    }
}

<?php

namespace App\Http\Controllers;

//Supports auth
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

//Models are a must to access database since Controller <=> Model <=> DB
use App\Models\Publication;

class PublicationController extends Controller
{
    //Returns the main publications page
    public function index(){
        return view('publications.index');
    }
    
    //Returns the create publication page
    public function create(){
        return view('publications.create');
    }

    //Inserts a publication into database (needs to pass validation tests before insertion)
    public function store(Request $request){

        //Validation
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'type' => 'required',
            'hidden' => 'required',
            'fixedPrice' => 'required|numeric', //ex : 0.00
            'expirationOfBid' => 'nullable',
            'postalCode' => 'required'
        ]);

        $data['user_id'] = getUID();
        //Insertion
        $newPublication = Publication::create($data);

        //Redirect to index page
        //!!! In the future, the route will redirect to "mes annonces"
        return redirect(route('publications.index'));
    }
}

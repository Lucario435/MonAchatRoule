<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//Models are a must to access database since Controller <=> Model <=> DB
use App\Models\Bid;

class BidController extends Controller
{
    public function store(Request $request)
    {
        //Validation /////////To Do Jonathan : More validation
        //Validate that the current sent bid is more than the previous highest bid on that publication
        $data = $request->validate([
            //publication validation
            'priceGiven' => 'required',
            'bidStatus' => 'required',
            'publication_id' => 'required',
        ]);

        //Si l'utilisateur n'est pas connecté, on redirige vers la page connexion
        if(Auth::check())
        {
            $data['user_id'] = Auth::id();
            ///////////////////////////////////////////////////////////////////////////////
            //Insertion
            $newBid = Bid::create($data);
            return redirect(route('publication.detail', ['id' => $data['publication_id']]))->with('message', 'Votre enchère a été déposé avec succès!');
        }
        else
        {
            return redirect(route('login'))->with('message', 'Vous devez être connecté pour déposer une enchère!');
        }
    }
}

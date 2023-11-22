<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Publication;
use Illuminate\Support\Facades\DB;
//Models are a must to access database since Controller <=> Model <=> DB
use App\Models\Bid;

class BidController extends Controller
{
    public function store(Request $request)
    {
        //Validation /////////To Do Jonathan : More validation
        $data = $request->validate([
            //publication validation
            'priceGiven' => 'required',
            'bidStatus' => 'required',
            'publication_id' => 'required',
        ]);
        
        //If the user isn't connected, it will redirect hum to connection page with a message
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
            //Validate that the current sent bid is more than the previous highest bid on that publication
            $highestBid = Bid::where('publication_id', $data['publication_id'])
            ->orderBy('priceGiven', 'desc') // Order bids in descending order by amount
            ->first()->priceGiven;

            if($highestBid + 50 <= $data['priceGiven'])
            {
                return redirect(route('login'))->with('message', 'Vous devez déposer une enchère plus élevé que la précédente!');
            }
            else
            {
                return redirect(route('login'))->with('message', 'Vous devez être connecté pour déposer une enchère!');
            }
        }
    }

    public function refreshDiv($id)
    {
        //Need publication, and bid

        $publication = Publication::find($id);

        $publicationBids = Bid::where('publication_id',$id)->get();


        return view('partials.bidlist')->with(['publication' => $publication,'bids' => $publicationBids]);
    }

    public function getHighestBidValue($id)
    {
        $priceGiven = @Bid::where('publication_id', $id)
        ->orderBy('priceGiven', 'desc') // Order bids in descending order by amount
        ->first()->priceGiven;

        if($priceGiven == null)
            $priceGiven = Publication::find($id)->fixedPrice;

        return $priceGiven;
        
    }
}

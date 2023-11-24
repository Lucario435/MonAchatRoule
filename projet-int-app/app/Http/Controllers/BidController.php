<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Publication;
use Illuminate\Support\Facades\DB;
//Models are a must to access database since Controller <=> Model <=> DB
use App\Models\Bid;
use App\Models\Suiviannonce;

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
            //If the publication bid is finished or not
            if(!$this->bidEnded($data['publication_id']))
            {
                $data['user_id'] = Auth::id();
                ///////////////////////////////////////////////////////////////////////////////
                //Insertion
                $newBid = Bid::create($data);
                /// Ajoute a la liste des annonces suivis la premire fois que user bid
                $this->UserFollowPublication($data['publication_id'],Auth::id());
                return redirect(route('publication.detail', ['id' => $data['publication_id']]))->with('message', 'Votre enchère a été déposé avec succès!');
            }
            else
            {
                //Redirect to detail page with message
                return redirect(route('publication.detail', ['id' => $data['publication_id']]))->with('message', 'Cette enchère est terminé, elle ne peux plus reçevoir de dépôt...');

            }
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

    //Returns a bool of if a publication bid has terminated or not
    public function bidEnded($id)
    {
        $publication = Publication::find($id);
        return strtotime($publication->expirationOfBid) <= time();
    }

    public function refreshDiv($id)
    {
        //Need publication, and bid

        $publication = Publication::find($id);

        $publicationBids = Bid::where('publication_id',$id)->get();

        return view('partials.bidlist')->with(['publication' => $publication,'bids' => $publicationBids,'bidEnded' => $this->bidEnded($id)]);
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
    private function UserFollowPublication($publicationId,$userId){
        $isFollowing = Suiviannonce::all()->where('publication_id',$publicationId)->where('userid',$userId);
        if(!count($isFollowing)){
            Suiviannonce::create(['userid'=>$userId,'publication_id'=>$publicationId]);
        }
    }
}

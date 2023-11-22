    @php
    use App\Models\User;
    use App\Models\Bid;
        $bidExist = False;
    @endphp
    @if($bids != null)
        @foreach ($bids as $publicationBid)
            @php
                $bidExist = True;
            @endphp
        @endforeach
    @endif
    <!--Get le plus haut enchère-->
    @if($bidExist)
        @php
            $highestBid = Bid::where('publication_id', $publication->id)
                ->orderBy('priceGiven', 'desc') // Order bids in descending order by amount
                ->first();
        @endphp
        @if($highestBid != null)
            @php
                //Get the usernames
                $user_id = $highestBid->user_id;
                $user = User::find($user_id);
                $username = $user->username;
            @endphp
            <div title="{{$highestBid->created_at}}" class="historic-bids-container">
                <i class="fav-icon fas fa-crown" style="color:goldenrod"></i><span class="text-emphasis text-adapt">{{$username}}</span><span style="padding: 5px">|</span><span class="text-emphasis text-adapt">{{$highestBid->priceGiven}} $</span>
                @if($bidEnded && Auth::id() == $publication->user_id)
                    <a title="Contacter" href="{{ route('messageUser', ['id' => $user_id]) }}" class="icon-click fav-icon fas fa-envelope noDec" style="padding: 5px"></a>
                @endif
            </div>
        @endif
        <!--Get le deuxième plus haut enchère-->
        @php
            $secondHighestBid = Bid::where('publication_id', $publication->id)
                ->orderBy('priceGiven', 'desc') // Order bids in descending order by amount
                ->skip(1) // Skip the first highest bid
                ->take(1) // Take one record, which will be the second highest bid
                ->first();
        @endphp
        @if($secondHighestBid != null)
            @php
                //Get the usernames
                $user_id = $secondHighestBid->user_id;
                $user = User::find($user_id);
                $username = $user->username;
            @endphp
            <div class="historic-bids-container">
                <i class="fav-icon fas fa-crown" style="color:gray"></i><span class="text-emphasis text-adapt">{{$username}}</span><span style="padding: 5px">|</span><span class="text-emphasis text-adapt">{{$secondHighestBid->priceGiven}} $</span>
                @if($bidEnded && Auth::id() == $publication->user_id)
                    <a title="Contacter" href="{{ route('messageUser', ['id' => $user_id]) }}" class="icon-click fav-icon fas fa-envelope noDec" style="padding: 5px"></a>
                @endif
            </div>
        @endif
        <!--Get le troisième plus haut enchère-->
        @php
            $thirdHighestBid = Bid::where('publication_id', $publication->id)
                ->orderBy('priceGiven', 'desc') // Order bids in descending order by amount
                ->skip(2) // Skip the first highest bid
                ->take(1) // Take one record, which will be the second highest bid
                ->first();
        @endphp
        @if($thirdHighestBid != null)
            @php
                //Get the usernames
                $user_id = $thirdHighestBid->user_id;
                $user = User::find($user_id);
                $username = $user->username;
            @endphp
            <div class="historic-bids-container">
                <i class="fav-icon fas fa-crown" style="color:brown"></i><span class="text-emphasis text-adapt">{{$username}}</span><span style="padding: 5px">|</span><span class="text-emphasis text-adapt">{{$thirdHighestBid->priceGiven}} $</span>
                @if($bidEnded && Auth::id() == $publication->user_id)
                    <a title="Contacter" href="{{ route('messageUser', ['id' => $user_id]) }}" class="icon-click fav-icon fas fa-envelope noDec" style="padding: 5px"></a>
                @endif
            </div>
        @endif
        <!--Get le reste des bids dans l'ordre du plus haut au plus bas-->
        @php
            $restOfBid = null;
            if(Bid::count() >= 4)
            {
                $restOfBid = Bid::where('publication_id', $publication->id)
                    ->orderBy('priceGiven', 'desc') // Order bids in descending order by amount
                    ->offset(3)
                    ->limit(99999999999) // Skip the first highest bid
                    ->get();
            }
        @endphp
        @if($restOfBid)
            @foreach ($restOfBid as $publicationBid)
                @php
                    //Get the usernames
                    $user_id = $$publicationBid->user_id;
                    $user = User::find($user_id);
                    $username = $user->username;
                @endphp
                <div class="historic-bids-container">
                    <i class="fav-icon fas fa-crown" style="color:lightblue"></i><span class="text-emphasis text-adapt">{{$username}}</span><span style="padding: 5px">|</span><span class="text-emphasis text-adapt">{{$publicationBid->priceGiven}} $</span>
                    @if($bidEnded && Auth::id() == $publication->user_id)
                        <a title="Contacter" href="{{ route('messageUser', ['id' => $user_id]) }}" class="icon-click fav-icon fas fa-envelope noDec" style="padding: 5px"></a>
                    @endif
                </div>
            @endforeach
        @endif
    @else
            <p style="font-weight: bolder;font-size:15px;">Aucune enchère pour le moment...</p>
    @endif
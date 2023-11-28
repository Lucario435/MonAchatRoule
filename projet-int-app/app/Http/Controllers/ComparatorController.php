<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Publication;
use Illuminate\Support\Facades\DB;
//Models are a must to access database since Controller <=> Model <=> DB
use App\Models\Bid;
use App\Models\Suiviannonce;

class ComparatorController extends Controller
{
    public function index(int $car1,int $car2){

        $car1 = Publication::find($car1);

        $car2 = Publication::find($car2);

        $default = "";

        if($car1 == null)
        {
            $default = "--";
        }
        if($car2 == null)
        {
            $default = "--";
        }

        return view('comparators.index', ['car1' => $car1, 'car2' => $car2, 'default' => $default]);
    }
}

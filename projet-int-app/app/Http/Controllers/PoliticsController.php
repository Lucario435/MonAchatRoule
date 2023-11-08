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
    public function index()
    {
        return redirect(route(''));
    }
}

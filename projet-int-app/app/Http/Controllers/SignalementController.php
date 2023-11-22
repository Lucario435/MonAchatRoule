<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signalement;

class SignalementController extends Controller
{
    public function index()
    {

        $signalements = Signalement::all()->sortBy('status');


        $signalements->each(function ($signalement) {
            // return [
            //     'created_at' => $signalement->created_at->format('F j, Y, g:i a'),
            //     'id'=> $signalement->id,
            //     'mcontent'=>$signalement->mcontent,
            //     'updated_at'=>$signalement->updated_at,
            //     'user_sender'=>$signalement->user_sender,
            //     'user_target'=>$signalement->user_target,
            //     'status'=>$signalement->status
            // ];

        });
        foreach ($signalements as $key => $value) {
            $signalements[$key]->formatted_time = $signalements[$key]->created_at->format('d-m-Y');
        }
        //dd($signalements);
        return view("admin.index", ['signalements' => $signalements]);
    }
}
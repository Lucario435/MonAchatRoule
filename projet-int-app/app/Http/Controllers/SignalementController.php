<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signalement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SignalementController extends Controller
{
    public function index(Request $request)
    {

        $signalements = Signalement::all()->sortBy('status');


        foreach ($signalements as $key => $value) {
            $signalements[$key]->formatted_time = $signalements[$key]->created_at->format('d-m H:i');
        }
        //dd($signalements);

        if ($request->query()) {
            $params = [];
            foreach($request->query() as $key => $value){
                $params = [$key,$value];
            }
            //dd($params);
            if($params[1] != 'none')
                $signalements = $signalements->where($params[0],$params[1]);
            //dd($signalements);
            return view("admin.list-signalements",['signalements' => $signalements]);
        }
        //dd($signalements);
        return view("admin.index", ['signalements' => $signalements]);
    }
    public function process(Request $request)
    {
        //dd($request->json('commentaire'));
        $id = $request->json('id');
        // je ne sais pas si on devrait ajouter un commentaire... dans la table
        $commentaire = $request->json('commentaire');

        $updated = DB::table('signalements')->where('id', $id)->update(['status' => 1,'user_resolved_by' => Auth::id()]);

        return response()->json(['status' => $updated]);
    }
}
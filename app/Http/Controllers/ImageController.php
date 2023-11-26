<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    //Jonathan : This controller doesn't have a index page

    //Returns the create publication page

    //TO DO: Verify that the user is connected else redirect to connection page
    public function create($pid){
        $plist = Auth::user()->getPublications;
        foreach ($plist as $key => $value) {
            if($pid == $plist[$key]->id)
                $ptitle = $plist[$key]->title;
        }
        //dd($ptitle);
        // dump($plist);
        return view('images.create',["plist" => $plist,"pid"=>$pid,"ptitle"=>$ptitle]);
    }


    public function edit_annonce(Request $r, $pid){
        $p = Publication::find($pid);
        if($p == null){
            return to_route("index");
        }
        $imageList = $p->images;
        //dd($imageList);
        $plist = [$p];
        foreach ($plist as $key => $value) {
            if($pid == $plist[$key]->id)
                $ptitle = $plist[$key]->title;
        }
        return view("images.create",["pid" => $pid, "isEdit" => true, "ilist" => $imageList,"plist" => $plist,"ptitle"=>$ptitle]);
    }


    public function edit_annonce_recu(Request $r){
        error_log($r);
        return $this->store($r);
    }


    public function deleteImage(Request $r, $iid){
        $img = Image::find($iid);if($img == null){return to_route("index");}
        $p = Publication::find($img->publication_id);if($p == null){return to_route("index");}
        if($img == null){return to_route("index");}
        if($p->user_id != Auth::id()){
            return to_route("index");
        }
        Storage::delete($img->url);
        $img->delete();

        return to_route("index",["message" => "L'image a été supprimé"]);
    }


    public function store(Request $request){
        //dd($request);
        //Validation
        $data = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:999999', // Adjust the allowed file types and size limit as needed
            "publication_id" => "required"
        ]);
        //dd($data,"s");
        $p = Publication::find($request["publication_id"]);
        if($p == null){return to_route("index");}
        if($p->user_id != Auth::id() ){return to_route("index");}
        if($request->file('images.*') == null){return to_route("index");}
        foreach ($request->file('images.*') as $imagefile) {
            $image = new Image();
            //Creates the path of the imagefile
            $path = $imagefile->store('/images/resource', ['disk' => 'my_files']);
            //Inserts the url path to the model
            $image->url = strval($path);
            error_log("path; $path");
            error_log("image id:$image->id, url : $image->url ");
            Log::info("$image ");
            //The default publication id is 2 but will be the choosen one in the page once the connexion is done
            $image->publication_id = $request["publication_id"];
            $image->user_id = Auth::id();
            //Saves the Model into the database
            $image->save();
        }
        //Redirect to index page
        //!!! In the future, the route will redirect to "mes annonces" or the page "détail" and the user will be able to see it on top of the list
        return redirect(route('publication.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    //Jonathan : This controller doesn't have a index page
    
    //Returns the create publication page

    //TO DO: Verify that the user is connected else redirect to connection page
    public function create(){
        return view('images.create');
    }


    public function store(Request $request){

        //Validation
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:16384', // Adjust the allowed file types and size limit of 16MB
        ]);

        foreach ($request->file('images.*') as $imagefile) {
            $image = new Image;
            //Creates the path of the imagefile
            $path = $imagefile->store('/images/resource', ['disk' =>   'my_files']);

            //Inserts the url path to the model
            $image->url = strval($path);

            //The default publication id is 2 but will be the choosen one in the page once the connexion is done
            $image->publication_id = 2;

            //Saves the Model into the database
            $image->save();
        }

        //Redirect to index page
        //!!! In the future, the route will redirect to "mes annonces" or the page "détail" and the user will be able to see it on top of the list
        return redirect(route('publication.index'));
    }
}

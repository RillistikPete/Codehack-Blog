<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Photo;

class AdminMediaController extends Controller
{
    public function index(){

        $photos = Photo::all();

        return view('admin.media.index', compact('photos'));

    }

    public function create(){

        return view('admin.media.create');

    }

    public function store(Request $request){

        // $_FILES['file'] - superglobal

        $file = $request->file('file');

        $name = time() . $file->getClientOriginalName();

        $file->move('images', $name);

        Photo::create(['file'=>$name]);

    }

    public function destroy($id) {

        $photo = Photo::findOrFail($id);

        unlink(public_path() . $photo->file );
        
        $photo->delete();

        return redirect('/admin/media');

    }

    public function deleteMedia(Request $request) {

        $photos = Photo::findOrFail($request->checkboxArray);

        foreach($photos as $photo)
        {
            $photo->delete();
        }

            //did this myself
            if(count($request->checkboxArray) > 1){

                flash('Media photos deleted');
            }
            else{
                flash('Media photo deleted');
                
            }

        return redirect()->back();


    }



}

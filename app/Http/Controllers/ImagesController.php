<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImagesController extends Controller
{
    function postNewImage(Request $request){
        $this->validate($request, [
            'file' => 'mimes:jpeg,bmp,png|max:3000'
        ]);
        if($request->hasFile('file')){
            $file = $request->file('file');
            $file->move(public_path('images/tmp/'), $file->getFilename().'.'.$file->getClientOriginalExtension());
            return $file->getFilename();
        }
        abort(500);
    }
}
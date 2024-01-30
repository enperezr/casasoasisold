<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class CubaController extends Controller
{

    public function getIndex(Request $request){
        return view('cuba.base');
    }
}
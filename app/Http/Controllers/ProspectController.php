<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Prospect;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProspectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function save(Request $request)
    {
        $prospect = new Prospect;
        $prospect->plan_id = $request->input('plan');
        $prospect->name = $request->input('names');
        $prospect->phone = $request->input('phones');
        $prospect->message = $request->input('client_messages');
        $prospect->save();
        return view('create.prospect-saved');
    }

    public function update(Request $request){
        $id = $request->input('id');
        $prospect = Prospect::findOrFail($id);
        $prospect->processed = $request->input('state');
        $prospect->reason = $request->input('reason');
        $prospect->save();
        return $prospect;
    }

}

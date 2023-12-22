<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Helper;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access:admin|moderador');
    }

    public function getIndex()
    {
        $ads = Ad::all();
        return view('admin.ads', ['ads'=>$ads]);
    }

    public function getToggle($id){
        $ad = Ad::findOrFail($id);
        $ad->active = abs($ad->active - 1);
        $ad->save();
        return redirect(Helper::getPathFor('admin/ads'));
    }

    public function getEdit($id){
        $ad = Ad::findOrFail($id);
        $pages = Page::all();
        return view('admin.ads-edit', ['ad'=>$ad, 'pages'=>$pages]);
    }

    public function getNew(){
        $pages = Page::all();
        $ad = new Ad;
        $ad->places = '2,3';
        return view('admin.ads-edit', ['ad'=>$ad, 'pages'=>$pages]);
    }

    public function postSave(Request $request){
        $id = $request->input('id');
        if($id)
            $ad = Ad::findOrFail($id);
        else
            $ad = new Ad;
        $ad->name = $request->input('name');
        $ad->phone = $request->input('phone');
        $ad->fecha = $request->input('fecha');
        $ad->time = $request->input('time');
        $ad->link = $request->input('link');
        $ad->places = implode(',', $request->input('places'));
        $ad->priority = $request->input('priority');
        $ad->user_id = $request->user()->id;
        if($request->hasFile('resource')){
            $location = $request->file('resource')->move(public_path('images/ads'), str_slug($ad->name).'-'.str_random(4).'.'.$request->file('resource')->getClientOriginalExtension());
            @unlink(public_path($ad->resource));
            $ad->resource = substr(Helper::normalizePath($location), strlen(public_path())+1);
        }
        $ad->save();
        return redirect(Helper::getPathFor('admin/ads'));
    }

    public function getDelete($id){
        $ad = Ad::findOrFail($id);
        @unlink(public_path($ad->resource));
        $ad->delete();
        return redirect(Helper::getPathFor('admin/ads'));
    }
}

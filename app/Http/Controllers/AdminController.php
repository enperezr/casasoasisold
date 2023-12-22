<?php

/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 05/08/2015
 * Time: 13:15
 */

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Property;
use App\Prospect;
use App\User;
use App\UserAction;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',  ['except' => ['rebuildSiteMap']]);
        $this->middleware('access:admin|moderador|agente',['except' => ['rebuildSiteMap']]);
    }

    public function getDashboard(){
        $prospects = Prospect::orderBy('created_at', 'desc')->take(100)->get();
        return view('admin.newdashboard',['prospects'=>$prospects]);
    }

    public function postDashboard(Request $request){
        $query = $request->input('query');
        $all = explode(' ', $query);
        if(sizeof($all) > 1 ){
            $result = UserAction::getByContactName($all);
        }
        else{
            $result = UserAction::getByTemporalCode($query);
            if(!$result->count())
                $result = UserAction::getByContactName($query);
        }
        return view('admin.dashboard', ['result'=>$result, 'query'=>$query]);
    }

    public function getRelatedProperties(Request $request){
        $id = $request->input('id');
        $action  = UserAction::findOrFail($id);
        $properties = $action->properties;
        $contact = $action->contact;
        return view('admin.related', ['properties'=>$properties, 'contact'=>$contact]);
    }

    public function postSetActionTime(Request $request){
        $id = $request->input('id');
        $time = $request->input('time');
        $action = UserAction::findOrFail($id);
        $daysPassed = \Carbon\Carbon::today()->diffInDays($action->created_at);
        if($daysPassed > $action->time)
            $action->time = 0;
        else{
            $action->time = $action->time - $daysPassed;
        }
        $action->time = $action->time + $time;
        $action->created_at = Carbon::today();
        $action->save();
        return $action;
    }

    public function postSetActionConcluded(Request $request){
        $id = $request->input('id');
        $concluded = $request->input('concluded');
        $action = UserAction::findOrFail($id);
        $action->concluded = $concluded;
        $action->save();
        return $action;
    }

    public function rebuildSiteMap(Request $request){
        $static_urls = [
            'https://casasoasis.com/'=>[number_format(1, 2), 'daily'],
            'https://casasoasis.com/listado-casas-venta-permuta-cuba'=>[number_format(.9, 2), 'daily'],
            'https://casasoasis.com/nueva/propiedad'=>[number_format(.9, 2),false],
            'https://casasoasis.com/contactenos'=>[number_format(.9, 2), false],
            'https://casasoasis.com/descargas'=>[number_format(.2, 2), false],
            'https://casasoasis.com/venta'=>[number_format(.9, 2), 'daily'],
            'https://casasoasis.com/permuta'=>[number_format(.9, 2), 'weekly'],
            'https://casasoasis.com/en'=>[number_format(1, 2), 'daily'],
            'https://casasoasis.com/en/listado-casas-venta-permuta-cuba'=>[number_format(.9, 2), 'daily'],
            'https://casasoasis.com/en/nueva/propiedad'=>[number_format(.9, 2), false],
            'https://casasoasis.com/en/contactenos'=>[number_format(.9, 2), false],
            'https://casasoasis.com/en/descargas'=>[number_format(.2, 2), false],
            'https://casasoasis.com/en/venta'=>[number_format(.9, 2), 'daily'],
            'https://casasoasis.com/en/permuta'=>[number_format(.9, 2), 'daily'],
        ];
        # fetch all active houses
        $properties = Property::with('actions')
        ->whereIn(
            'id',
            UserAction::select('id')
            ->where('concluded', 0)
            ->whereRaw('DATE_ADD(date, INTERVAL time DAY) < CURDATE()')
            ->get()
        )
            ->where('active', 1)
            ->orderBy('date', 'DESC')
            ->get();
        
        $search_urls = [];
        $property_urls = [];

        foreach($properties as $property){
            foreach($property->actions as $action){
                $property_urls[$property->getUrl($action)] = [number_format(.6, 2), 1, $property]; // add the house

                //add the property type to search urls
                if(!array_has($search_urls, url($action->action->slugged.'/'.$property->typeProperty->slugged))){
                    $search_urls[url($action->action->slugged.'/'.$property->typeProperty->slugged)] = [number_format(.7, 2), 0];
                    $search_urls[url('en/'.$action->action->slugged.'/'.$property->typeProperty->slugged)] = [number_format(.7, 2), 0];
                }
                $search_urls[url($action->action->slugged.'/'.$property->typeProperty->slugged)][1]++;
                $search_urls[url('en/'.$action->action->slugged.'/'.$property->typeProperty->slugged)][1]++;
                
                // add the province to search urls
                if(!array_has($search_urls, url($action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged))){
                    $search_urls[url($action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged)] = [number_format(.6, 2), 0];
                    $search_urls[url('en/'.$action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged)] = [number_format(.6, 2), 0];
                }
                $search_urls[url($action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged)][1]++;
                $search_urls[url('en/'.$action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged)][1]++;

                //add municipality to search urls
                if(!array_has($search_urls, url($action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged.'/'.$property->municipio->slugged))){
                    $search_urls[url($action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged.'/'.$property->municipio->slugged)] = [number_format(.5, 2), 0];
                    $search_urls[url('en/'.$action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged.'/'.$property->municipio->slugged)] = [number_format(.5, 2), 0];
                }
                $search_urls[url($action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged.'/'.$property->municipio->slugged)][1]++;
                $search_urls[url('en/'.$action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged.'/'.$property->municipio->slugged)][1]++;

                //add locality to search urls
                if(!array_has($search_urls, url($action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged.'/'.$property->municipio->slugged.'/'.$property->locality->slugged))){
                    $search_urls[url($action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged.'/'.$property->municipio->slugged.'/'.$property->locality->slugged)] = [number_format(.5, 2), 0];
                    $search_urls[url('en/'.$action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged.'/'.$property->municipio->slugged.'/'.$property->locality->slugged)] = [number_format(.5, 2), 0];
                }
                $search_urls[url($action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged.'/'.$property->municipio->slugged.'/'.$property->locality->slugged)][1]++;
                $search_urls[url('en/'.$action->action->slugged.'/'.$property->typeProperty->slugged.'/'.$property->province->slugged.'/'.$property->municipio->slugged)][1]++;
            }
        }
        //$file = file(base_path('sitemap2.xml'));
        $xml = view('admin.sitemap', ['static_urls'=>$static_urls, 'search_urls'=>$search_urls, 'property_urls'=>$property_urls])->render();
        file_put_contents(public_path('sitemap.xml'), $xml);
        return redirect('/sitemap.xml');
    }

}
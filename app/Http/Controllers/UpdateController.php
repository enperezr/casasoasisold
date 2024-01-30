<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Contact;
use App\Helper;
use App\Property;
use App\UserAction;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Image;
use App\PropertiesCommodities;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{

    public static $NOMENCLATURES = ['actions','provinces', 'municipios', 'localities','commodities',
        'groups_type_property', 'rols', 'services', 'states_construction', 'types_construction',
        'types_error', 'types_kitchen', 'types_property', 'currencies'];

    public function getUpdateApp(Request $request){
        $since = $request->since;
        $upto = $request->upto;
        $properties = Property::getFullPropertiesSinceDate($since, $upto);
        $props_arr = [];
        $act_ids = [];
        $properties_per_action = [];
        foreach($properties as $p){
            $images = $p->images;
            $commodities = $p->commodities->pluck('id');
            $actions = $p->actions->pluck('id')->toArray();
            $arr = $p->toArray();
            $arr['images'] = $images;
            $arr['commodities'] = $commodities;
            $arr['actions'] = $actions;
            $props_arr[] = $arr;
            $act_ids = array_merge($actions, $act_ids);
            foreach($actions as $a){
                if(isset($properties_per_action[$a])){
                    $properties_per_action[$a][] = $p->id;
                }
                else{
                    $properties_per_action[$a] = [$p->id];
                }
            }
        }

        $actionsCollection = UserAction::whereIn('id', $act_ids)
            ->with('services')
            ->get();

        $actions_arr = [];
        $gestores = [];
        foreach($actionsCollection as $action){
            $services = $action->services->pluck('id');
            $arr = $action->toArray();
            $arr['services'] = $services;
            $arr['properties'] = $properties_per_action[$action->id];
            $actions_arr[] = $arr;
            if($action->gestor){
                $gestor = $action->gestor_user;
                $contact = $gestor->gestor_contact;
                //print_r($action); exit();
                $action->contact_id = $contact->id;
                $contact->avatar = $gestor->avatar;
                $contact->gestor = 1;
                $gestores[] = $contact;
            }
        }

        $conts_id = $actionsCollection->pluck('contact_id');
        $contacts = Contact::whereIn('id', $conts_id)->get();
        $processed = collect([]);
        foreach ($gestores as $gestore){
            if($processed->contains($gestore->id))
                continue;
            for($i = 0; $i< $contacts->count(); $i++){
                if($gestore->id == $contacts[$i]->id){
                    $contacts[$i]->avatar = $gestore->avatar;
                    $contacts[$i]->gestor = 1;
                }
            }
            $processed->push($gestore->id);
        }

        $resultados = [];
        $resultados['properties'] = $props_arr;
        $resultados['actions'] = $actions_arr;
        $resultados['contacts'] = $contacts->toArray();

        return Helper::ravelString(json_encode($resultados));
    }

    public function getUpdateTerms(Request $request){
        $n = $request->input('n');
        if(array_search($n, UpdateController::$NOMENCLATURES) !== false){
            return Helper::ravelString(json_encode(DB::table($n)->get()));
        }
        else
            abort(404);
    }

    public function getUpdateAds(Request $request){
        //return json_encode(Ad::getAvailable());
        return Helper::ravelString(json_encode(Ad::getAvailable()));
    }

    public function getDbVersion(Request $request){
        return '2.0';
    }

    public function getPartialUpdate(Request $request){
        //properties modified since
        //actions modified since
        //contacts modified since
        //images created since
        //commodities changes
        $since = $request->since;
        $properties = Property::getFullPropertiesSinceDate($since);

        $actions = UserAction::getActionsSinceDate($since);
        $contacts = Contact::getContactsSinceDate($since);
        $images = Image::getImagesSinceDate($since);
        $commodities = PropertiesCommodities::getCommoditiesSinceDate($since);
        return json_encode(['properties'=>$properties, 'actions'=>$actions, 'contacts'=>$contacts, 'images'=>$images, 'commodities'=>$commodities]);
    }
}

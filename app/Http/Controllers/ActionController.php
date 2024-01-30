<?php

namespace App\Http\Controllers;


use App\Action;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class ActionController extends Controller
{

    public function postSaveAction(Request $request){
        //action (comprar, permutar, alquilar, rentar)
        $data = $request->all();
        $action = Action::where('slugged',$data['operation'])->first();
        $action_data = [];
        $action_data['description'] = $data['description'];
        $action_data['time'] = $data['time'];
        $action_data['created_at'] = Carbon::now();
        $action_data['protected_by'] = array_has($data, 'inmobiliaria') ? $data['inmobiliaria'] : null;

        switch($data['operation']){
            case 'comprar':
                $action_data['price'] = $data['price'];
                break;
            case 'permutar':
                $action_data['permuta'] = $data['option'];
                break;
            default:
                $action_data['price'] = $data['price'];
                $action_data['frequency'] = $data['frequency'];

        }

        /*
        //services (for the actions of rentar y alquilar)
        if($data['operation'] == 'alquilar' || $data['operation'] == 'rentar'){
            $action_property = PropertyAction::where('property_id', $property->id)->where('action_id',$action->id)->first();
            if(array_has($data, 'service')){
                $services = [];
                foreach($data['service'] as $s){
                    $services[$s] = ['property_id'=>$property->id, 'action_id'=>$action_property->action_id, 'created_at'=>Carbon::now()];
                }
                $action_property->services()->attach($services);
            }
        }
        */
    }
}

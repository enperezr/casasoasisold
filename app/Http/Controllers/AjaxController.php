<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\Locality;
use App\Municipio;
use App\Property;
use App\PropertyAction;
use App\Province;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class AjaxController extends Controller
{

    /**
     * Query the server for a resource with optional parameters
     * @param $item
     * @param Integer  $arg1
     * @param Integer $arg2
     *
     * @return json
     */
    public function getPropertiesCount($action, $type=null, $province=null){
        if($type == null)
            return Property::countPerAttributes('property_type_id', $action, $province)->groupBy('property_type_id');
        elseif($province == null)
            return Property::countPerAttributes('province_id', $action, $type)->groupBy('province_id');
        return json_encode(0);
    }

    /**
     * Return the municipios of this province, and the localities from the first municipio fetched
     * @param $province, could be an slugged string or the id
     * @return mixed
     */
    public function getMunicipiosLocalities($province){
        if(!is_numeric($province)){
            $prov = Province::where('slugged', $province)->first();
            if(!$prov)
                return ['municipios' => [], 'localities' => []];
            $province = $prov->id;
        }
        $municipios = Municipio::where('province_id', $province)->get();
        $localities = Locality::where('municipio_id', $municipios[0]->id)->get();
        return ['municipios' => $municipios, 'localities' => $localities];
    }

    /**
     * Return the localities from this municipio
     * @param $municipio, could be an slugged string or the id
     * @return mixed
     */
    public function getLocalities($municipio){
        if(!is_numeric($municipio)){
            $mun = Municipio::where('slugged', $municipio)->first();
            if(!$mun)
                return [];
            $municipio = $mun->id;
        }
        $localities = Locality::where('municipio_id',$municipio)->get();
        return $localities;
    }


    public function getCommoditiesUnlocalized($group_id){
        return $this->getCommodities(null, $group_id);
    }

    /**
     * Return the Commodities/Extras that has this group_id
     * @param $group_id
     * @return mixed
     */
    public function getCommodities($lang, $group_id){
        $commodities = Commodity::whereIn('group_id', [$group_id, 7])->get();
        return $commodities;
    }

    public function postRateProperty(Request $request, $property, $value){
        $property = PropertyAction::find($property);
        $property->saveRate($value);
        $rate_now = $property->calculateRate();
        $response = new Response($rate_now);
        $prop = $property->property;
        $prop->update(['rate_now'=>$rate_now]);
        $response->withCookie(cookie('property'.$property->id.'rated', true, 60));
        return $response;
    }

    public function getPropertyImages(Request $request, $property_id){
        $property = Property::findOrFail($property_id);
        return $property->images;
    }
}

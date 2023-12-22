<?php

namespace App;

use Illuminate\Support\Facades\DB;

class PropertyAction extends CachedModel
{
    protected $table = 'properties_actions';

    protected $guarded = ['id'];

    public static $rules = [
        'operation'=>'required|in:1,2,3',
        'price'=>'required_if:operation,1,3|integer', //operation comprar has id 1, rentar has id 3
        'option'=>'required_if:operation,2', //operation permutar has id 2
        'frequency'=>'required_if:operation,3|integer' //operation rentar has id 3
    ];

    function action(){
        return $this->belongsTo('App\Action');
    }

    function property(){
        return $this->belongsTo('App\Property', 'id');
    }

    function services(){
        return $this->belongsToMany('App\Service', 'actions_services', 'properties_action_id')->withPivot('property_id','action_id');
    }

    function contact(){
        return $this->belongsTo('App\Contact');
    }

    function rate(){
        return $this->hasOne('App\Rate', 'properties_action_id');
    }

    function reviews(){
        return $this->hasMany('App\Review', 'properties_action_id');
    }

    /**
     * How many properties are in every action
     * @return mixed
     */
    public static function countPropertiesPerAction(){
        return PropertyAction::select('action_id',DB::raw('COUNT(*) as "total"'))->groupBy('action_id')->get();
    }

    public function saveRate($value){
        $rate = Rate::where('properties_action_id',$this->id)->first();
        $field = 'values_'.$value;
        if(!$rate) {
            $rate = new Rate;
            $rate->properties_action_id = $this->id;
            $rate->property_id = $this->property->id;
        }
        switch($value){
            case 1:
                $rate->values_1 = $rate->values_1+1;
                break;
            case 2:
                $rate->values_2 = $rate->values_2+1;
                break;
            case 3:
                $rate->values_3 = $rate->values_3+1;
                break;
            case 4:
                $rate->values_4 = $rate->values_4+1;
                break;
            case 5:
                $rate->values_5 = $rate->values_5+1;
                break;
        }
        $rate->save();
    }

    public function calculateRate(){
        $rate = $this->rate;
        if(!$rate)
            return 0;
        $total = $rate->values_1 * 1 + $rate->values_2 * 2 + $rate->values_3 *3 + $rate->values_4 *4 + $rate->values_5 *5;
        if($total == 0)
            return $total;
        return $total/($rate->values_1 + $rate->values_2 + $rate->values_3 + $rate->values_4 + $rate->values_5);
    }
}

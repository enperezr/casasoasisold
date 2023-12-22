<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    public function properties(){
        return $this->hasMany('App\Property');
    }

    public function getCommission($rol){
        $commision = Commission::where('plan_id', $this->id)->where('rol_id', $rol->id)->first();
        if(!$commision){
            $commision = new Commission;
            $commision->value = 0;
        }
        return $commision;
    }
}

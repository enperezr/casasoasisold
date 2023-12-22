<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends CachedModel
{
    protected $fillable = ['property_id', 'arrival_date','name', 'email', 'days', 'people', 'comment'];

    public static $rules = [
        'property_id'=>'required|integer',
        'arrival_date'=>'required',
        'name'=>'required',
        'email'=>'required|email',
        'days'=>'required|integer',
        'people'=>'required|integer',
    ];
    /**
     * The property on this Reservation
     * @return Property Collection property or QueryBuilder handler method
     */
    public function properties(){
        return $this->belongsTo('App\Property');
    }
}

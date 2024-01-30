<?php

namespace App;

use DB;

class Commodity extends CachedModel
{
    protected $table = 'commodities';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'in_renta', 'group_id'];


    /**
     * The properties with this type of construction
     * @return Profile Collection property or QueryBuilder handler method
     */
    public function properties(){
        return $this->belongsToMany('App\Property');
    }
    /**
     * Find skill by name
     * @param $name
     * @return mixed
     */
    public static function findByName($name){
        return Commodity::where('name', $name)->first();
    }

}

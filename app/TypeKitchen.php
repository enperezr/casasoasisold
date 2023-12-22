<?php

namespace App;

use DB;

class TypeKitchen extends CachedModel
{

    protected $table = 'types_kitchen';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


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
        return TypeKitchen::where('name', $name)->first();
    }

}

<?php

namespace App;

use DB;

class Province extends CachedModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * The properties with this type of construction
     * @return Property Collection property or QueryBuilder handler method
     */
    public function properties(){
        return $this->hasMany('App\Property');
    }

    /**
     * The municipios with this province
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function municipios(){
        return $this->hasMany('App\Municipio');
    }

    /**
     * Find skill by name
     * @param $name
     * @return mixed
     */
    public static function findByName($name){
        return Province::where('name', $name)->first();
    }

    public static function findSlugged($slugged){
        return Province::where('slugged', $slugged)->first();
    }

    public static function getUrls(){
        $provinces = array_pluck(Province::all(['slugged'])->all(), 'slugged');
        return '('.mb_strtolower(implode('|',$provinces )).')';
    }

}

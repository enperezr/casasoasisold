<?php

namespace App;

use DB;

class Municipio extends CachedModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * The properties with this municipio
     * @return Property Collection property or QueryBuilder handler method
     */
    public function properties(){
        return $this->hasMany('App\Property');
    }

    /**
     * The localities with this municipio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function localities(){
        return $this->hasMany('App\Locality');
    }


    /**
     * The province of this municipio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(){
        return $this->belongsTo('App\Province');
    }
    /**
     * Find skill by name
     * @param $name
     * @return mixed
     */
    public static function findByName($name){
        return Municipio::where('name', $name)->first();
    }
   
    public static function getProvinciaByPluralSlugged($municipioSlugged){       
        $municipio = Municipio::where('slugged', $municipioSlugged)->first();
        $province = null;
        if($municipio)
           $province = Province::where('id',$municipio->province_id)->first();   
        return $province;
    }

    



}

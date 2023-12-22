<?php

namespace App;

use DB;
use Illuminate\Support\Collection;

class Locality extends CachedModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * The properties with this locality
     * @return Property Collection property or QueryBuilder handler method
     */
    public function properties(){
        return $this->hasMany('App\Property');
    }

    /**
     * The municipio of this locality
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function municipios(){
        return $this->belongsTo('App\Municipio');
    }

    /**
     * Find skill by name
     * @param $name
     * @return mixed
     */
    public static function findByName($name){
        return Locality::where('name', $name)->first();
    }

    public static function getMunicipioByPluralSlugged($localitySlugged){
        $locality = Locality::where('slugged', $localitySlugged)->first();
        $municipio = null;
        if($locality)
           $municipio = Municipio::where('id',$locality->municipio_id)->first();
        return $municipio;
    }

}

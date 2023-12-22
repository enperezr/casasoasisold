<?php

namespace App;

class PropertiesCommodities extends CachedModel
{
    protected static $no_cache = true;

    protected $table = 'properties_commodities';

    public static $rules = [

    ];

    public static function getCommoditiesSinceDate($fecha){
        $commodities = PropertiesCommodities::where('updated_at', '>', $fecha)->get();
        return $commodities;
    }
}

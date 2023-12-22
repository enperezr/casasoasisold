<?php

namespace App;

use DB;

class Image extends CachedModel
{

    protected static $no_cache = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['localization', 'description'];


    /**
     * The property on this image
     * @return Property Collection property or QueryBuilder handler method
     */
    public function property(){
        return $this->belongsTo('App\Property', 'property_id');
    }

    public static function getImagesSinceDate($fecha){
        $properties = Image::where('updated_at', '>', $fecha)->distinct('property_id')->get(['property_id']);
        return Image::whereIn('property_id', $properties)->get();
    }

}

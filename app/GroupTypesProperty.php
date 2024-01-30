<?php

namespace App;

use DB;

class GroupTypesProperty extends CachedModel
{

    protected $table = 'groups_type_property';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * This value represents all types, meaning commodities with this value,
     * are available for any property type
     * @var int
     */
    public static $COMODIN = 7;

    /**
     * The properties with this type of construction
     * @return Profile Collection property or QueryBuilder handler method
     */
    public function properties(){
        return $this->belongsTo('App\TypeProperty', 'group_id');
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

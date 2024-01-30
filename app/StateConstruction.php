<?php
namespace App;

use DB;

class StateConstruction extends CachedModel
{

    protected $table = 'states_construction';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * The properties with this state of construction
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
        return StateConstruction::where('name', $name)->first();
    }

}

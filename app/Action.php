<?php

namespace App;

use DB;

class Action extends CachedModel
{
    /**
     * The id of the comodin action, this action represents all actions at the time
     */
    const ACTION_ALL = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * The properties with this action, its price of sell, permuta detail, or frequency of payment if rent
     * @return Profile Collection property or QueryBuilder handler method
     */
    public function properties(){
        return $this->belongsToMany('App\Property')->withPivot('price', 'permuta', 'frequency');
    }

    /**
     * Find skill by name
     * @param $name
     * @return mixed
     */
    public static function findByName($name){
        return Action::where('name', $name)->first();
    }


    /**
     * get a regex expression to test urls that start by actions
     */
    public static function getUrls(){
        $actions = array_pluck(Action::cachedAll()->all(), 'slugged');
        unset($actions[2]);
        return '('.mb_strtolower(implode('|',$actions)).')';
    }

}

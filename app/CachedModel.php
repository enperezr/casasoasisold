<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CachedModel extends Model
{

    protected static $no_cache = false;

    /**
     * return a cached version of the table
     * TODO messing with the columns can be problematic
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function cachedAll($columns = ['*']){
        if(static::$no_cache){
            return static::all($columns);
        }
        else{
            $models = Cache::rememberForever(static::class, function() use ($columns)
            {
                return static::all($columns);
            });
        }
        return $models;
    }


    public function toString($nulls = false){
        $html = '';
        foreach($this->getAttributes() as $key=>$value){
            if(!$value){
                if($nulls)
                    $value = '-';
                else
                    continue;
            }
            $html.="<span><strong>$key: </strong>$value</span><strong> | </strong>";
        }
        return $html;
    }
}

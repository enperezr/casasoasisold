<?php

namespace App;

use DB;

class Message extends CachedModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['to', 'date_send', 'topic', 'content'];


    /**
     * The properties with this type of construction
     * @return Property Collection property or QueryBuilder handler method
     */
    public function users(){
        return $this->belongsTo('App\User');
    }

}

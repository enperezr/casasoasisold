<?php

namespace App;

class Review extends CachedModel
{
    protected $table = 'reviews';

    protected $guarded = ['id'];

    public function property(){
        return $this->belongsTo('App\Property', 'property_id');
    }
}

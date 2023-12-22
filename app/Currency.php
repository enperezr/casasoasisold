<?php

namespace App   ;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use DB;

class Currency extends CachedModel
{
    protected $table = 'currencies';
    public $timestamps = false;
}

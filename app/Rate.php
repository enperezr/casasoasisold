<?php

namespace App;

/**
 * @property int field
 */
class Rate extends CachedModel
{
    protected $table = 'rates';

    public $timestamps = false;
}

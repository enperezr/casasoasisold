<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ad extends Model
{
    protected $table = 'ads';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function pages(){
        $ids = explode(',', $this->places);
        $pages = Page::whereIn('id', $ids)->get();
        return $pages;
    }

    public function places_string(){
        $ids = explode(',', $this->places);
        $pages = Page::whereIn('id', $ids)->get();
        return implode(', ', $pages->pluck('name')->toArray());
    }

    public static function getAvailable(){
        $ads = DB::select('SELECT * FROM ads WHERE active = 1 AND ADDDATE(`fecha`, `time`) > CURRENT_DATE ORDER BY priority DESC');
        return $ads;
    }

}

<?php

namespace App;

use DB;

class Contact extends CachedModel
{
    protected static $no_cache = true;

    protected $table = 'contacts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static $rules = [
        'names'=>'required',
        'hours'=>'required',
        'phones'=>'required',
    ];

    /**
     * The properties with this contact
     * @return Property Collection property or QueryBuilder handler method
     */
    public function properties(){
        return $this->belongsToMany('App\Property', 'properties_actions', 'contact_id', 'property_id');
    }

    /**
     * The properties protected by this contact
     * @return Property Collection property or QueryBuilder method
     */
    public function protegees(){
        return $this->belongsToMany('App\Property', 'properties_actions', 'protected_by', 'property_id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function _gestor(){
        return $this->hasOne('App\User', 'contact_id');
    }


    /**
     * Find skill by name
     * @param $name
     * @return mixed
     */
    public static function findByName($names){
        return Contact::where('names', $names)->first();
    }

    public function getHoursAndDays(){
        $arr_hours = explode('-', $this->hours);
        $hours = '';
        $s = '';
        foreach($arr_hours as $h){
            if(intval($h) < 12)
                $hours.=$s.$h.'am';
            else
                $hours.=$s.(intval($h)-12).'pm';
            $s = ' - ';
        }
        $arr_days = explode('-', $this->days);
        $join = ' - ';
        if(count($arr_days) == 1){
            $arr_days = explode(',', $this->days);
            $join = ', ';
        }
        $days = '';
        $s = '';
        foreach($arr_days as $d){
            if($d)
                $days.=$s.trans('formats.week.day.'.$d);
            $s = $join;
        }
        return $days.' '.$hours;
    }

    public static function getContactsSinceDate($fecha){
        $contacts = Contact::where('updated_at', '>', $fecha)->get();
        return $contacts;
    }

}

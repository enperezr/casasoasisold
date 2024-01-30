<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;


class UserAction extends Model
{
    protected $table = 'user_actions';

    public function currency(){
        return $this->belongsTo('App\Currency','currency_id');
    }

    public function action(){
        return $this->belongsTo('App\Action', 'action_id');
    }

    public function contact(){
        return $this->belongsTo('App\Contact', 'contact_id');
    }

    public function gestor_user(){
        return $this->belongsTo('App\User', 'gestor');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function properties(){
        return $this->belongsToMany('App\Property', 'properties_actions','user_action_id', 'property_id');
    }

    public function services(){
        return $this->belongsToMany('App\Service', 'actions_services', 'user_action_id', 'service_id');
    }

    public function user_plan(){
        return $this->belongsTo('App\Plan', 'user_plan_id');
    }

    public function properties_actions(){
        return $this->hasMany('App\PropertyAction');
    }

    public function delete(){
        $this->services()->detach();
        $this->properties()->detach();
        parent::delete();
        return 1;
    }

    public static function getByTemporalCode($code){
        $command = UserAction::select('user_actions.*')->join('users', 'user_actions.user_id', '=', 'users.id')->where('users.temporary', $code);
        return $command->get();
    }

    public static function getByContactName($query){
        $command = UserAction::select('user_actions.*')->join('contacts', 'user_actions.contact_id', '=', 'contacts.id');
        if(is_array($query)){
            $command->where('contacts.names', 'like', '%'.$query[0].'%');
            unset($query[0]);
            foreach($query as $elem){
                $command->orWhere('contacts.names', 'like', '%'.$elem.'%');
            }
        }
        else{
            $command->where('contacts.names', 'like', '%'.$query.'%');
        }
        return $command->get();
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

    public static function getExpireds(){
        $sql = 'SELECT DISTINCT contacts.mail, contacts.phones, user_actions.created_at, user_actions.time,
                properties.id, properties.address
                FROM user_actions
                JOIN users ON users.id = user_actions.user_id
                JOIN contacts ON contacts.id = user_actions.contact_id
                JOIN properties_actions ON user_actions.id = properties_actions.user_action_id
                JOIN properties ON properties_actions.property_id = properties.id
                WHERE ADDDATE(properties.date,user_actions.time) < CURRENT_DATE() AND properties.active = 1';
        return DB::select($sql);
    }

    public static function deActivateExpireds(){
        $sql = 'UPDATE properties SET active = 0 where id IN
                (SELECT DISTINCT properties_actions.property_id FROM properties_actions
                JOIN user_actions ON properties_actions.user_action_id = user_actions.id
                WHERE ADDDATE(properties.date,user_actions.time) < CURRENT_DATE() AND properties.active = 1)';
        return DB::update($sql);
    }

    public static function getSoonExpireds($days_left){
        $sql = 'SELECT DISTINCT contacts.mail,contacts.phones, user_actions.created_at, user_actions.time,
                properties.id, properties.address
                FROM user_actions
                JOIN users ON users.id = user_actions.user_id
                JOIN contacts ON contacts.id = user_actions.contact_id
                JOIN properties_actions ON user_actions.id = properties_actions.user_action_id
                JOIN properties ON properties_actions.property_id = properties.id
                WHERE ADDDATE(properties.date,user_actions.time)
                BETWEEN ADDDATE(CURRENT_DATE(), ?) AND ADDDATE(CURRENT_DATE(), ?) AND properties.active = 1';
        return DB::select($sql, [$days_left, $days_left+1]);
    }

    public static function reActivateExpireds(){
        $sql = 'UPDATE properties SET active = 1 where id IN
                (SELECT DISTINCT properties_actions.property_id FROM properties_actions
                JOIN user_actions ON properties_actions.user_action_id = user_actions.id
                WHERE ADDDATE(properties.date,user_actions.time) < CURRENT_DATE() AND properties.active = 0)';
        return DB::update($sql);
    }

    public static function getActionsSinceDate($fecha){
        $actions = UserAction::with('properties_actions')->where('updated_at', '>', $fecha)->get();
        return $actions;
    }

}

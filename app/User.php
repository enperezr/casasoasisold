<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'rol_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The properties that this user has added
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties(){
        return $this->hasMany('App\Property');
    }

    public function actions(){
        return $this->hasMany('App\UserAction');
    }

    public function contacts(){
        return $this->hasMany('App\Contact');
    }

    public function gestor_contact(){
        return $this->belongsTo('App\Contact', 'contact_id');
    }

    /**
     * The rol of this user
     * @return Rol Model
     */
    public function rol(){
        return $this->belongsTo('App\Rol');
    }

    /**
     * Mutator to assign Rol Model to User Model
     * @param Rol $rol
     */
    public function setRolAttribute(Rol $rol){
        $this->attributes['rol_id'] = $rol->id;
    }

    public function getFullname(){
        if($this->profile != null)
            return $this->profile->first_name.' '.$this->profile->last_name;
        else
            return $this->name;
    }

    public static function getByTemporalCode($code){
        return User::where('temporal', $code)->first();
    }

    public static function getByContactName($query){
        $command = User::select('users.*')->join('contacts', 'users.id', '=', 'contacts.user_id');
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
        print_r($command->toSql());
        return $command->get();
    }

    public static function getGestors(){
        return User::with('gestor_contact')->where('gestor', 1)->where('active', 1)->get();
    }

    public static function getProviders(){
        return User::whereIn('rol_id', Rol::where('assignable', 1)->get()->pluck('id'))->where('active', 1)->get();
    }
}

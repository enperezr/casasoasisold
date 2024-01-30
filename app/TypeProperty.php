<?php
namespace App;

use DB;

use Illuminate\Support\Facades\Cache;

class TypeProperty extends CachedModel
{
    /**
     * The comodin property. this property represents all types of property at the same time
     */
    const PROPERTY_ALL = 12;

    protected $table = 'types_property';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * The properties with this type of construction
     * @return Profile Collection property or QueryBuilder handler method
     */
    public function properties(){
        return $this->belongsToMany('App\Property');
    }
    /**
     * Find skill by name
     * @param $name
     * @return mixed
     */
    public static function findByName($name){
        return TypeProperty::where('name', $name)->first();
    }

    public static function getUrls(){
        $types = array_pluck(TypeProperty::cachedAll()->all(), 'slugged');
        $routes = '('.mb_strtolower(implode('|',$types )).')';
        return $routes;
    }

    public static function getPluralUrls(){
        $types = array_pluck(TypeProperty::all(), 'sluggedplural');
        $routes = '('.mb_strtolower(implode('|',$types )).'|viviendas)';
        return $routes;
    }

    public static function getOnlyUrl($singularUrl){
       $pluralUrl = TypeProperty::where('slugged',$singularUrl)->first();
       return $pluralUrl->sluggedplural;
    }
    
    public static function findBySlugged($type){
        if(is_array($type))
            return TypeProperty::whereIn('sluggedplural', $type)->get();
        else
            return TypeProperty::where('sluggedplural', $type)->first();
    }

}

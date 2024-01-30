<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Property extends CachedModel
{

    protected static $no_cache = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'active', 'highlighted'];

    public static $rules = [
        'surface' => 'required|integer',
        'rooms' => 'required|integer',
        'baths' => 'required|integer',
        'address' => 'required',
        'floors' => 'required|integer',
        'highness' => 'required|integer',
        'parcela' => 'integer',
        'property_type_id' => 'required|exists:types_property,id',
        'construction_type_id' => 'required|exists:types_construction,id',
        'property_state_id' => 'required|exists:states_construction,id',
        'kitchen_type_id' => 'required|exists:types_kitchen,id',
        'province_id' => 'required|exists:provinces,id',
        'municipio_id' => 'required|integer',
        'locality_id' => 'integer',
        'user_id' => 'integer',
        'active' => 'boolean',
        'highlighted' => 'boolean'
    ];

    public function images()
    {
        return $this->hasMany('App\Image', 'property_id');
    }

    public function typeProperty()
    {
        return $this->belongsTo('App\TypeProperty', 'property_type_id');
    }

    public function typeConstruction()
    {
        return $this->belongsTo('App\TypeConstruction', 'construction_type_id');
    }

    public function stateConstruction()
    {
        return $this->belongsTo('App\StateConstruction', 'property_state_id');
    }

    public function typeKitchen()
    {
        return $this->belongsTo('App\TypeKitchen', 'kitchen_type_id');
    }

    public function province()
    {
        return $this->belongsTo('App\Province');
    }

    public function municipio()
    {
        return $this->belongsTo('App\Municipio');
    }

    public function locality()
    {
        return $this->belongsTo('App\Locality');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function rates()
    {
        return $this->hasMany('App\Rate', 'property_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review', 'property_id');
    }

    public function actions()
    {
        return $this->belongsToMany('App\UserAction', 'properties_actions', 'property_id', 'user_action_id')->withPivot('description');
    }

    public function commodities()
    {
        return $this->belongsToMany('App\Commodity', 'properties_commodities');
    }

    public function services()
    {
        return $this->hasMany('App\ActionsServices', 'property_id');
    }


    public function actionPivot($action)
    {
        return PropertyAction::where('property_id', $this->id)->where('action_id', $action->id)->first();
    }

    /**
     * add a where clause to test $column between $min and $max
     * @param $query
     * @param $column
     * @param null $min
     * @param null $max
     * @return mixed
     */
    public function scopeBetween($query, $column, $min = null, $max = null)
    {
        if (is_numeric($min) && is_numeric($max))
            return $query->whereBetween($column, [$min, $max]);
        elseif (is_numeric($min))
            return $query->where($column, '>=', $min);
        elseif (is_numeric($max))
            return $query->where($column, '<=', $max);
        return $query;
    }

    /**
     * add a where clause to test $column equals $value until certain $limit of $value
     * if $limit is supered then test $column equals or bigger to $limit
     * @param $query
     * @param $column
     * @param $limit
     * @param $value
     * @return mixed
     */
    public function scopeExactOrMore($query, $column, $limit, $value)
    {
        if (!is_numeric($value))
            return $query;
        if ($value < $limit)
            return $query->where($column, '>=', $value);
        else
            return $query->where($column, '>=', $limit);
    }

    /**
     * filter to only those that has all the extras specified
     * the problem is called "relational division" and is solved using a subquery grouping having and counting
     * ex: select * from properties where id in
     * (select property_id from properties_commodities where commodity_id in [extras] group by property_id having count(*)=count(extras))
     * @param $query
     * @param $extras
     */
    public function scopeExtras($query, $extras)
    {
        //find all the properties with all the extras
        if (is_numeric($extras))
            $extras = [$extras];
        $ids = PropertiesCommodities::select('property_id')
            ->whereIn('commodity_id', $extras)
            ->groupBy('property_id')
            ->havingRaw('Count(*) =' . count($extras))
            ->get();
        $flattened = $ids->flatten();
        //now we can just return a wherein query
        return $query->whereIn('properties.id', $flattened);
    }

    /**
     * The same problem that with extras, just note that there is another table involved in the relation
     * @param $query
     * @param $services
     */
    public function scopeServices($query, $services)
    {
        if (is_numeric($services))
            $services = [$services];
        $ids = ActionsServices::select('property_id')
            ->whereIn('service_id', $services)
            ->groupBy('property_id')
            ->havingRaw('Count(*) =' . count($services))
            ->get();

        $flattened = $ids->flatten();
        //now we can just return a wherein query
        return $query->whereIn('properties.id', $flattened);
    }

    /**
     * Perform search by this attributes, if any is 0 it will not be included on the search. The difference between
     * this function and the search() function, is that here the attributes are simplified to its id form, so no extra
     * query need to be issue to gather ids for the main query. This function is include to simplify and optimize ajax
     * search
     * @param $action
     * @param $type
     * @param $province
     * @param $municipio
     * @param $locality
     * @param $tstate
     * @param $ttype_construction
     * @param $price_min
     * @param $price_max
     * @param $condition
     * @param $surface_min
     * @param $surface_max
     * @param $rooms
     * @param $baths
     * @param $extras
     * @param $services
     * @param null $order
     * @param null $paginate
     *
     * @return mixed
     */
    public static function idSearch(
        $action,
        $type,
        $province,
        $municipio,
        $locality,
        $tstate,
        $ttype_construction,
        $price_min,
        $price_max,
        $currency,
        $condition,
        $surface_min,
        $surface_max,
        $rooms,
        $baths,
        $extras,
        $services,
        $order = null,
        $paginate = null
    ) {
        //start query, not doing this can produce that equally named columns on related tables overwrite themselves
        $query = Property::select('properties.*');
        $query->join('properties_actions', 'properties.id', '=', 'properties_actions.property_id');
        $query->join('user_actions', 'user_actions.id', '=', 'properties_actions.user_action_id');
        /**
         * the query should return a call to this function on success
         * Add final modifiers(orders, pagination) to the query, execute and return the result
         * @param $query
         * @param $order
         * @param $paginate
         * @return mixed
         */
        function finishSearchAndReturn($query, $order, $paginate)
        {
            $query = $query->with(['actions', 'typeProperty', 'province', 'municipio', 'locality']);
            $query = $query->orderBy('has_images', 'DESC');
            if (!$order || $order == 'recent')
                $query = $query->orderBy('created_at', 'DESC');
            if ($order == 'oldest')
                $query = $query->orderBy('created_at', 'ASC');
            if ($order == 'expensive')
                $query = $query->orderBy('user_actions.price', 'DESC');
            if ($order == 'cheap')
                $query = $query->orderBy('user_actions.price', 'ASC');
            if ($order == 'big')
                $query = $query->orderBy('surface', 'DESC');
            if ($order == 'small')
                $query = $query->orderBy('surface', 'ASC');
            if ($paginate)
                return $query->paginate($paginate);
            return $query->get();
        }
        //take care of args parameters(type_construction, state_construction, prices, surfaces, rooms, baths)
        $query = Helper::addWhereToCommand($query, 'property_state_id', $tstate);
        $query = Helper::addWhereToCommand($query, 'construction_type_id', $ttype_construction);

        if ($action == '2') {
            if ($condition != '0' && $condition != '') {
                if ($condition == 'multiple') {
                    $query = Helper::addWhereToCommand($query, 'user_actions.condition', '1x1', '<>');
                } else {
                    $query = Helper::addWhereToCommand($query, 'user_actions.condition', '%' . $condition . '%', 'like');
                }
            }
        } else {

            if ($price_min != 0 || $price_max != 999999999) {
                $query = $query->between('user_actions.price', $price_min, $price_max);
            }

            if($currency != 0){
                $query = $query->addWhereToCommand('user_actions.currency', $currency,'=');
            }
        }

        if ($rooms > 1)
            $query = $query->exactOrMore('rooms', 4, $rooms);
        if ($baths > 1)
            $query = $query->exactOrMore('baths', 4, $baths);
        if ($surface_min != 0 || $surface_max != 999999999)
            $query = $query->between('surface', $surface_min, $surface_max);

        //special extras
        if ($extras && !empty($extras)) {
            $query = $query->extras($extras);
        }

        //special services
        if ($services && !empty($services)) {
            $query = $query->services($services);
        }

        //construct query based on parameter existance
        if ($action != 4) //not include in query if action is comodin
            $query = Helper::addWhereToCommand($query, 'user_actions.action_id', $action);
        if ($type != 0) //not include in query if action is comodin
            $query = Helper::addWhereToCommand($query, 'property_type_id', $type);

        if ($province != 0) {
            $query = Helper::addWhereToCommand($query, 'province_id', $province);
        }
        if ($municipio != 0) {
            //TODO verify when municipio not belong to province
            $query = Helper::addWhereToCommand($query, 'municipio_id', $municipio);
        }
        if ($locality != 0) {
            //TODO verify when locality not belong to municipio
            $query = Helper::addWhereToCommand($query, 'locality_id', $locality);
        }
        $query = Helper::addWhereToCommand($query, 'properties.active', 1);

        return finishSearchAndReturn($query, $order, $paginate);
    }

    /**
     * perform a search by this attributes, if any is null it will not be included on the search
     * @param $action
     * @param $type
     * @param $province
     * @param $municipio
     * @param $locality
     * @param $tstate
     * @param $ttype_construction
     * @param $price_min
     * @param $price_max
     * @param $surface_min
     * @param $surface_max
     * @param $rooms
     * @param $baths
     * @param $extras
     * @param null $order
     * @param null $paginate
     * @return bool|mixed
     */
    public static function search(
        $action,
        $type,
        $province,
        $municipio,
        $locality,
        $tstate,
        $ttype_construction,
        $price_min,
        $price_max,
        $currency,
        $condition,
        $surface_min,
        $surface_max,
        $rooms,
        $baths,
        $extras,
        $services,
        $order = null,
        $paginate = null
    ) {
        //special extras
        if (!empty($extras)) {
            $extras = Helper::resolveForQuery(Commodity::class, 'slugged', $extras);
        }

        //special services
        if (!empty($services)) {
            $services = Helper::resolveForQuery(Service::class, 'slugged', $services);
        }
        //take care of url parameters (action, type, province, municipio, locality)
        //resolve models by slugged representation

        $action = Helper::resolveForQuery(Action::class, 'slugged', $action);
        $type = Helper::resolveForQuery(TypeProperty::class, 'slugged', $type);
        $provinceId = Helper::resolveForQuery(Province::class, 'slugged', $province);
        $municipioId = Helper::resolveForQuery(Municipio::class, 'slugged', $municipio);
        $localityId = Helper::resolveForQuery(Locality::class, 'slugged', $locality);

        return self::idSearch(
            $action,
            $type,
            $provinceId,
            $municipioId,
            $localityId,
            $tstate,
            $ttype_construction,
            $price_min,
            $price_max,
            $currency,
            $condition,
            $surface_min,
            $surface_max,
            $rooms,
            $baths,
            $extras,
            $services,
            $order,
            $paginate
        );
    }


    public static function countPerAction(
        $type = null,
        $province = null,
        $municipio = null,
        $locality = null,
        $state_contruction = null,
        $construction_type = null
    ) {
        $command = Property::select('properties_actions.action_id as action_id', DB::raw('Count(*) as total'))->groupBy('action_id');
        $command->join('properties_actions', 'properties.id', '=', 'properties_actions.property_id');

        if ($type && !is_numeric($type))
            $type = TypeProperty::where('slugged', $type)->first()->id;
        if ($province && !is_numeric($province))
            $province = Province::where('slugged', $type)->first()->id;
        if ($municipio && !is_numeric($municipio))
            $municipio = Municipio::where('slugged', $municipio)->first()->id;
        if ($locality && !is_numeric($locality))
            $locality = Locality::where('slugged', $locality)->first()->id;

        if ($type) {
            $command->where('property_type_id', $type);
        }
        if ($province) {
            $command->where('province_id', $province);
        }
        if ($municipio) {
            $command->where('municipio_id', $municipio);
        }
        if ($locality) {
            $command->where('locality_id', $locality);
        }
        if ($state_contruction) {
            $command->where('property_state_id', $state_contruction);
        }
        if ($construction_type) {
            $command->where('construction_type_id', $construction_type);
        }
        $command = Helper::addWhereToCommand($command, 'active', 1);
        return $command->get();
    }

    /**
     * perform a count by this attributes
     * @param $grouping
     *      should a string with column name
     * @param null $action
     *      could be: a number, treated as id; a string, treated as slugged column; an array, treatment
     * by type of first element
     * @param null $type
     *      could be: a number, treated as id; a string, treated as slugged column; an array, treatment
     * by type of first element
     * @param null $province
     *      could be: a number, treated as id; a string, treated as slugged column; an array, treatment
     * by type of first element
     * @param null $municipio
     *      could be: a number, treated as id; a string, treated as slugged column; an array, treatment
     * by type of first element
     * @param null $locality
     *      could be: a number, treated as id; a string, treated as slugged column; an array, treatment
     * by type of first element
     * @param null $state_contruction
     *      could be: a number, treated as id; a string, treated as slugged column; an array, treatment
     * by type of first element
     * @param null $construction_type
     *      could be: a number, treated as id; a string, treated as slugged column; an array, treatment
     * by type of first element
     * @return mixed
     *      scalar
     */
    public static function countPerAttributes(
        $grouping,
        $action = null,
        $type = null,
        $province = null,
        $municipio = null,
        $locality = null,
        $state_contruction = null,
        $construction_type = null
    ) {

        //resolver for slugged values

        $command = Property::select('properties.id', $grouping, DB::raw('Count(properties.id) as total'))->groupBy($grouping);
        $command->join('properties_actions', 'properties.id', '=', 'properties_actions.property_id');
        $command->join('user_actions', 'user_actions.id', '=', 'properties_actions.user_action_id');
        if ($action != Action::ACTION_ALL)
            $command = Helper::addWhereToCommand($command, 'user_actions.action_id', $action);
        if (is_numeric($type) && $type != TypeProperty::PROPERTY_ALL)
            $command = Helper::addWhereToCommand($command, 'property_type_id', $type);
        $command = Helper::addWhereToCommand($command, 'province_id', $province);
        $command = Helper::addWhereToCommand($command, 'municipio_id', $municipio);
        $command = Helper::addWhereToCommand($command, 'locality_id', $locality);
        $command = Helper::addWhereToCommand($command, 'property_state_id', $state_contruction);
        $command = Helper::addWhereToCommand($command, 'construction_type_id', $construction_type);
        $command->where('properties.active', '=', 1);
        return $command->get();
    }

    public static function countPerMunicipio($action = null, $group = null)
    {
        $command = Property::select(
            'provinces.name as pname',
            'properties.province_id',
            'municipios.name as mname',
            'municipio_id',
            DB::raw('Count(*) as total')
        )->join('provinces', 'properties.province_id', '=', 'provinces.id')
            ->join('municipios', 'municipio_id', '=', 'municipios.id')
            ->groupBy('municipio_id');
        if ($action && $action != Action::ACTION_ALL) {
            $command->join('properties_actions', 'properties.id', '=', 'properties_actions.property_id')
                ->where('properties_actions.action_id', '=', $action);
        }
        if ($group) {
            $command->join('types_property', 'properties.property_type_id', '=', 'types_property.id')
                ->where('types_property.group_id', $group);
        }
        return $command->get();
    }

    /**
     * get the last ($total) properties added
     * @param int $total
     * @return mixed
     */
    public static function lasts($total = 12)
    {
        return Property::where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->take($total)
            ->with('actions', 'typeProperty', 'province', 'municipio', 'locality')
            ->get();
    }

    public static function highlighteds($total = 3, $action = false)
    {
        $command = Property::select('properties.*');
        if ($action) {
            $command->join('properties_actions', 'properties_actions.property_id', '=', 'properties.id')
                ->join('user_actions', 'properties_actions.user_action_id', '=', 'user_actions.id')
                ->where('user_actions.action_id', $action);
        }
        $command->orderBy('rate_now', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->take($total)
            ->with('actions', 'typeProperty', 'province', 'municipio', 'locality');
        $command = Helper::addWhereToCommand($command, 'active', 1);
        return $command->get();
    }

    public static function lastProperties($total = 6, $action = false, $pictures = false)
    {
        $command = Property::select('properties.*', 'properties_actions.user_action_id');
        if ($action) {
            $command->join('properties_actions', 'properties_actions.property_id', '=', 'properties.id')
                ->join('user_actions', 'properties_actions.user_action_id', '=', 'user_actions.id')
                ->where('user_actions.action_id', $action);
        }
        $command->orderBy('has_images', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->take($total)
            ->with('typeProperty', 'province', 'municipio', 'locality');
        if ($pictures)
            $command->where('has_images', 1);
        $command = Helper::addWhereToCommand($command, 'active', 1);
        $properties = $command->get();
        if ($action) {
            $ids = $properties->pluck('user_action_id');
            $actions = UserAction::whereIn('id', $ids)->get();
            for ($i = 0; $i < $properties->count(); $i++) {
                foreach ($actions as $a) {
                    if ($properties[$i]->user_action_id == $a->id) {
                        $properties[$i]->actions = Collection::make([$a]);
                        break;
                    }
                }
            }
        }

        return $properties;
    }

    /**
     * return the url for this property
     */
    public function getUrl($action)
    {
        if (!$action)
            $action = $this->actions->first();
        if (is_numeric($action))
            $action = UserAction::findOrFail($action);
        $url = $action->action->slugged;
        $url .= '/' . $this->typeProperty->slugged;
        $url .= '/' . $this->province->slugged;
        $url .= '/' . $this->municipio->slugged;
        $url .= '/' . ($this->locality ? $this->locality->slugged . '/' : '');
        $url .= $this->id;
        return \App\Helper::getPathFor($url);
    }

    public function getBreadcrumbsLinks($action)
    {
        if (!$action)
            $action = $this->actions->first();
        if (is_numeric($action))
            $action = Action::findOrFail($action);
        $uri = '';
        $urls = array();
        //$urls[] = array(Helper::getPathFor($uri), trans('messages.words.start'));
        $uri .= $action->action->slugged;
        $urls[] = array(\App\Helper::getPathFor($uri), trans('messages.db.action.' . $action->action->slugged));
        $uri .= '/' . $this->typeProperty->slugged;
        $urls[] = array(\App\Helper::getPathFor($uri), trans_choice('messages.db.property.' . $this->typeProperty->slugged, 2));
        $uri .= '/' . $this->province->slugged;
        $urls[] = array(\App\Helper::getPathFor($uri), $this->province->name);
        $uri .= '/' . $this->municipio->slugged;
        $urls[] = array(\App\Helper::getPathFor($uri), $this->municipio->name);
        $uri .= '/' . ($this->locality ? $this->locality->slugged . '/' : '');
        $this->locality ? $urls[] = array(\App\Helper::getPathFor($uri), $this->locality->slugged) : false;
        return $urls;
    }

    /**
     * Get the action data for this action, if $action happens to be the comodin search then return all actions
     * from this property
     * @param $action
     * @return array or bool
     */
    public function getThisAction($action)
    {
        $actions = $this->actions;
        if ($action == 'busqueda' || is_object($action) && $action->id == Action::ACTION_ALL)
            return $actions->all();
        foreach ($actions as $a) {
            if ($a->action->slugged == $action)
                return [$a];
            if (is_object($action) && $a->action->id == $action->id)
                return [$a];
        }
        return false;
    }

    public function getLabelName()
    {
        return trans('messages.property.type.locality', [
            'type' => trans_choice('messages.db.property.' . $this->typeProperty->slugged, 1),
            'locality' => ($this->locality && $this->locality->name != 'sin localidad') ? $this->locality->name : $this->municipio->name
        ]);
    }

    public function getMainPicture()
    {
        $front = false;
        $images = $this->images;
        if ($images->count() > 0)
            $front = $images[0];
        foreach ($images as $img) {
            if ($img->front) {
                $front = $img;
                break;
            }
        }
        return $front;
    }

    /**
     * TODO require changes in db and bussines model, just returning now the same as main picture
     *
     * should return a picture suitable for banner in the house
     *
     */
    public function getPortalPicture()
    {
        return $this->getMainPicture();
    }

    public function getSimilars($action, $total)
    {
        return Property::whereHas('actions', function ($query) use ($action) {
            $query->where('action_id', $action->id);
            $query->where('concluded', 0);
        })->where('municipio_id', $this->municipio_id)
            ->where('id', '!=', $this->id)
            ->where('active', 1)
            ->with('actions', 'typeProperty', 'province', 'municipio', 'locality')->take($total)->get();
    }

    public function rate($action)
    {
        $propertyAction = PropertyAction::find($action->pivot->id);
        return $propertyAction->calculateRate();
    }

    public function getKeyWordsForAction($action)
    {
        $keywords = 'Cuba, ';
        $keywords .= trans_choice('messages.words.journey', 2) . ', ';
        $keywords .= trans_choice('messages.words.host', 2) . ', ';
        $keywords .= trans('messages.db.action.' . $action->slugged) . ', ';
        $keywords .= trans_choice('messages.db.property.' . $this->typeProperty->slugged, 2) . ', ';
        $keywords .= $this->province->name . ', ';
        $keywords .= $this->municipio->name . ', ';
        $keywords .= ($this->locality ? $this->locality->name . ', ' : '');
        return $keywords;
    }

    public static function getFullPropertiesSinceDate($fecha = false)
    {
        if (!$fecha)
            $fecha = Carbon::minValue();
        $properties = Property::where('active', 1)
            ->orderBy('updated_at', 'DESC')
            ->where('updated_at', '>', $fecha)
            ->with('commodities', 'images', 'actions')
            ->get();

        return $properties;
    }

    public function getEvaluations()
    {
    }

    public function delete()
    {
        $this->commodities()->detach();
        $this->actions()->detach();
        $this->images()->delete();
        return parent::delete();
    }
}

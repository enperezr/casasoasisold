<?php

namespace App\Http\Controllers;

use App\Action;
use App\Commodity;
use App\Contact;
use App\Currency;
use App\GroupTypesProperty;
use App\Helper;
use App\Locality;
use App\Municipio;
use App\Plan;
use App\Property;
use App\Province;
use App\Review;
use App\Service;
use App\StateConstruction;
use App\TypeConstruction;
use App\TypeError;
use App\TypeKitchen;
use App\TypeProperty;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class PortalController extends Controller
{
    public function getIndex($lang = null)
    {
        if ($lang && !in_array($lang, Config::get('app.languages')))
            abort(404);
        $actions = Action::cachedAll()->groupBy('slugged');
        $currencies = Currency::All();
        $sale_properties = Property::lastProperties(8, $actions['venta'][0]->id);
        $highlighted_sales = Property::highlighteds(4, $actions['venta'][0]->id);
        $exchange_properties = Property::lastProperties(8, $actions['permuta'][0]->id);
        $highlighted_exchanges = Property::highlighteds(4, $actions['permuta'][0]->id);
        $data = [
            'actions' => $actions,
            'currencies' => $currencies,
            'types' => TypeProperty::All(),
            'provinces' => Province::cachedAll(),
            'groups' => GroupTypesProperty::cachedAll(),
            'last_sales' => $sale_properties,
            'highlighted_sales' => $highlighted_sales,
            'last_exchanges' => $exchange_properties,
            'highlighted_exchanges' => $highlighted_exchanges,
            'tab_active' => 'index',
            'subtab_active' => 'viviendas',
        ];
        return view('portal.index', $data);
    }
    //--------------- search -----------------------------------
    public function getSearchUnLocalized(
        Request $request,
        $action,
        $type_property = null,
        $province = null,
        $municipio = null,
        $locality = null,
        $identifier = null
    ) {
        return $this->getSearch($request, null, $action, $type_property, $province, $municipio, $locality, $identifier);
    }
    public function getSearch(
        Request $request,
        $lang,
        $qaction,
        $type_property = null,
        $province = null,
        $municipio = null,
        $locality = null,
        $identifier = null
    ) {
        if ($municipio) {
            $tempProvincia = Municipio::getProvinciaByPluralSlugged($municipio);
            if (!$tempProvincia)
                abort(404);
        }

        if ($locality) {
            $tempMunicipio = Locality::getMunicipioByPluralSlugged($locality);
            if (!$tempMunicipio)
                abort(404);
        }

        if ($identifier || is_numeric($locality)) {
            if (is_numeric($locality)) //no identifier, numeric locality means no locality its a url like /action/type/province/municipio/identifier
                $identifier = $locality;
            $property = Property::with('actions', 'typeProperty', 'province', 'municipio', 'locality')
                ->where('id', $identifier)->first();

            if (
                !$property
                || $property->typeProperty->sluggedplural != $type_property
                || $property->province->slugged != $province
                || ($property->locality && $property->locality->slugged != $locality)
            )
                abort(404);
            else {
                $propertyAction = $property->getThisAction($qaction)[0];
                if (!$propertyAction)
                    abort(404);
                $data = [
                    'action' => $propertyAction,
                    'property' => $property,
                    'possible_errors' => TypeError::all(),
                    //'rated' => $request->cookie('property' . $propertyAction->id . 'rated')
                ];
                $response = view('portal.inmueble', $data);
                return $response;
            }
        } else {
            $qaction == 'busqueda' ? $qaction = 'venta' : false;
            $action = $qaction;
            $gestor = $request->input('gestor', 1);
            $textras = $request->input('extras', []);
            $tservices = $request->input('service', []);
            $tstate = $request->input('state', null);
            $ttype_construction = $request->input('type_construction', null);
            $ttype_property = $request->input('type_property') ? $request->input('type_property') : $type_property;
            $ttype_property = ($ttype_property == 'viviendas') ? $ttype_property = 0 : $ttype_property;
            $price_min = $request->input('pricemin', null);
            $price_max = $request->input('pricemax', null);
            $currency = $request->input('currency', null);
            $condition = $request->input('condition', null);
            $surface_min = $request->input('surfacemin', null);
            $surface_max = $request->input('surfacemax', null);
            $rooms = $request->input('rooms', null);
            $baths = $request->input('baths', null);
            $order = $request->input('order', null);


            if ($request->has('action')) {
                $action = $request->input('action', $action);
                $province = $request->input('province', $province);
                $municipio = $request->input('municipio', $municipio);
                $locality = $request->input('locality', $locality);
                $price_min = $request->input('price_min');
                $price_max = $request->input('price_max');
                $currency = $request->input('currency');
                $condition = $request->input('condition');
                $type_property = $request->input('type_property') ? $request->input('type_property') : $type_property;
                $type_property = ($type_property == 'viviendas') ? $type_property = 0 : $type_property;
                $ttype_property = $type_property;
                $type_construction = $request->input('type_construction');
                $state = $request->input('state');
                $surface_min = $request->input('surface_min');
                $surface_max = $request->input('surface_max');
                $extras = $request->input('extras');
                $search = Property::idSearch(
                    $gestor,
                    $action,
                    $type_property,
                    $province,
                    $municipio,
                    $locality,
                    $state,
                    $type_construction,
                    $price_min,
                    $price_max,
                    $currency,
                    $condition,
                    $surface_min,
                    $surface_max,
                    $rooms,
                    $baths,
                    $extras,
                    $order,
                    12
                );
            } else {

                $search = Property::search(
                    $gestor,
                    $action,
                    $ttype_property,
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
                    $textras,
                    $order,
                    12
                );
            }

            if ($search) {
                $tprovince = null;
                $tmunicipio = null;
                $tlocality = null;
                $taction = null;
                $ttype = null;
                $type_id = null;
                $locality_id = null;
                $province_id = null;
                $municipio_id = null;
                $action_id = null;
                $municipios = [];
                $localities = [];
                $provinces = Province::cachedAll();
                $placeRela = null;
                if (is_numeric($action))
                    $taction = Action::find($action);
                else
                    $taction = Action::where('slugged', $action)->first();
                if ($ttype_property) {
                    if (is_numeric($ttype_property))
                        $ttype = $ttype_property;
                    else
                        $ttype = $type_id = TypeProperty::findBySlugged($ttype_property)->id;
                }

                if ($province) {
                    if (is_numeric($province))
                        $tprovince = Province::find($province);
                    else
                        $tprovince = Province::where('slugged', $province)->first();
                    $province_id = $tprovince->id;
                    $municipios = Municipio::where('province_id', $tprovince->id)->get();
                    $placeRela = $tprovince;
                }
                if ($municipio) {
                    if (is_numeric($municipio))
                        $tmunicipio = Municipio::find($municipio);
                    else
                        $tmunicipio = Municipio::where('slugged', $municipio)->first();
                    $municipio_id = $tmunicipio->id;
                    $localities = Locality::where('municipio_id', $tmunicipio->id)->get();
                    $placeRela = $tmunicipio;
                }

                if ($locality) {
                    if (is_numeric($locality))
                        $tlocality = Locality::find($locality);
                    else
                        $tlocality = Locality::where('slugged', $locality)->first();
                    $locality_id = $tlocality->id;
                    $placeRela = $tlocality;
                }
                //TODO this counters can issue extra querys that can be avoided, is needed performance this can be a point to improve
                $propertiesPerAction = Property::countPerAttributes('action_id', $gestor, $taction->id, $ttype, $province_id, $municipio_id, $locality_id)->groupBy('action_id');
                //title------------------------------
                $type_property_slugged = $type_property;

                if (is_numeric($type_property)) {
                    if ($type_property == 0)
                        $type_property_slugged = 'viviendas';
                    else
                        $type_property_slugged = TypeProperty::findOrFail($type_property)->sluggedplural;
                }

                $property_trans = $type_property ? trans_choice('messages.db.property.' . $type_property_slugged, 2) : trans_choice('messages.words.property', 2);
                $place = ($locality && $tlocality->name != 'unspecified' && $tlocality->name != 'sin localidad') ? $tlocality->name
                      : ($tlocality?trans('messages.words.otherlocalities'):($municipio ? $tmunicipio->name
                        : ($province ? $tprovince->name
                            : trans('messages.words.everywhere'))));

                            $property_trans2 = $type_property ? trans_choice('messages.db.property.' . $type_property_slugged,1) : trans_choice('messages.words.property', 1);
                            $place = ($locality && $tlocality->name != 'unspecified' && $tlocality->name != 'sin localidad') ? $tlocality->name
                                  : ($tlocality?trans('messages.words.otherlocalities'):($municipio ? $tmunicipio->name
                                    : ($province ? $tprovince->name
                                        : trans('messages.words.everywhere'))));
                //----------------------------------
                $give = $want = null;
                if ($condition != 'multiple' && $condition != 0) {
                    $d = explode('x', $condition);
                    if (is_numeric($d[0])) {
                        $give = $d[0];
                    }
                    if (count($d) > 1 && is_numeric($d[1])) {
                        $want = $d[1];
                    }
                }
                $data = [
                    'title' => trans(
                        'messages.actions.seeking.properties',
                        ['properties' => $property_trans, 'place' => $place, 'action' => trans('messages.db.action.' . $qaction)]
                    ),
                    'h1' => trans(
                        'messages.actions.seeking.properties.h1',
                        ['properties' => $property_trans, 'place' => $place, 'action' => trans('messages.db.action.' . $qaction)]
                    ),
                    'h3' => $property_trans2,
                    'properties' => $search,
                    'tprovince' => $tprovince,
                    'tmunicipio' => $tmunicipio,
                    'tlocality' => $tlocality,
                    'order' => $order,
                    'price_min' => $price_min,
                    'price_max' => $price_max,
                    'tcurrency' => $currency,
                    'condition' => $condition,
                    'give' => $give,
                    'want' => $want,
                    'surface_min' => $surface_min,
                    'surface_max' => $surface_max,
                    'rooms' => $rooms,
                    'baths' => $baths,
                    'ttype' => $ttype,
                    'tstate' => $tstate,
                    'taction' => $taction,
                    'ttypeConstruction' => $ttype_construction,
                    'textras' => $textras,
                    'tservices' => $tservices,
                    'actions' => Action::cachedAll(),
                    'types' => TypeProperty::All(),
                    'groups' => GroupTypesProperty::cachedAll(),
                    'states' => StateConstruction::cachedAll(),
                    'typesConstruction' => TypeConstruction::cachedAll(),
                    'extras' => Commodity::cachedAll(),
                    'services' => Service::cachedAll(),
                    'provinces' => $provinces,
                    'municipios' => $municipios,
                    'localities' => $localities,
                    'placeRela' => $placeRela,
                    'propertiesPerAction' => $propertiesPerAction,
                    'request' => $request,
                    'search' => $search,
                    'currencies' => Currency::All(),
                    'tab_active' => $taction->slugged,
                    'subtab_active' => $type_property_slugged,
                ];
                return view('portal.search', $data);
            } else {
                abort(404);
            }
        }
    }
    public function getAjaxSearch(Request $request)
    {
        $gestor = $request->input('gestor', 1);
        $action = $request->input('action');
        $province = $request->input('province');
        $municipio = $request->input('municipio');
        $locality = $request->input('locality');
        $price_min = $request->input('price_min');
        $price_max = $request->input('price_max');
        $currency = $request->input('currency');
        $condition = $request->input('condition');
        $rooms = $request->input('rooms');
        $baths = $request->input('baths');
        $type_property = $request->input('type');
        $type_construction = $request->input('type_construction');
        $state = $request->input('state');
        $surface_min = $request->input('surface_min');
        $surface_max = $request->input('surface_max');
        $extras = $request->input('extras');
        $order = $request->input('order');
        $actionObject = Action::find($action);
        $search = Property::idSearch($gestor, $action, $type_property, $province, $municipio, $locality, $state, $type_construction, $price_min, $price_max, $currency, $condition, $surface_min, $surface_max, $rooms, $baths, $extras, $order, 12);
        $search->setPath($request->input('path'));
        return view('shared.propertiesList', ['search' => $search, 'action' => $actionObject, 'order' => $order]);
    }
    //-------------- upload property ---------------------------
    public function getNewPropertyUnlocalized(Request $request, $apk = false)
    {
        return $this->getNewProperty($request, null, $apk);
    }
    public function getNewProperty(Request $request, $lang, $apk = false)
    {
        //if(!Auth::user()){
        if (!$request->get('plan'))
            return view('create.choose', ['plans' => Plan::where('active', 1)->get(), 'apk' => $apk]);
        else {
            $plan = Plan::where('days', $request->get('plan'))->first();
            if (!$plan) {
                abort(404);
            }
            //return view('create.prospect', ['plans'=>Plan::where('active', 1)->get(), 'plan'=>$plan]);
            //}
            //}
            $provinces = Province::cachedAll();
            $municipios = Municipio::where('province_id', $provinces[0]->id)->get();
            $localities = Locality::where('municipio_id', $municipios[0]->id)->get();
            $gestors = User::getGestors();
            $providers = User::getProviders();
            $plans = Plan::where('active', 1)->get();
            $currencies = Currency::all();

            $data = [
                'provinces' => $provinces,
                'municipios' => $municipios,
                'localities' => $localities,
                'gestors' => $gestors,
                'providers' => $providers,
                'plans' => $plans,
                'types' => TypeProperty::All(),
                'actions' => Action::cachedAll(),
                'constructions' => TypeConstruction::cachedAll(),
                'states' => StateConstruction::cachedAll(),
                'kitchen' => TypeKitchen::cachedAll(),
                'commodities' => Commodity::cachedAll(),
                'services' => Service::cachedAll(),
                'contact' => new Contact(),
                'action' => new Action(),
                'currencies' => $currencies,
                'property' => new Property(),
                'apk' => $apk
            ];
            if (isset($plan))
                $data['plan'] = $plan;
            return view('create.property', $data);
        }
    }
    //-------------- comments -----------------------------------
    public function postCommentUnlocalized(Request $request)
    {
        return $this->postComment($request, null);
    }
    public function postComment(Request $request, $lang)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'text' => 'required',
            'property' => 'required|integer',
            'action' => 'required|integer'
        ]);
        $review = new Review();
        $review->name = $request->input('name');
        $review->email = $request->input('email');
        $review->phone = $request->input('phone');
        $review->text = $request->input('text');
        $review->property_id = $request->input('property');
        $review->properties_action_id = null; // todo eliminar columna
        if (Auth::user())
            $review->user_id = Auth::user()->id;
        $review->save();
        try {

            Mail::send('mail.adminnewcomment', ['review' => $review], function ($message) use ($review) {
                $message->from(Config::get('mail.from')['address'], Config::get('mail.from')['address']);
                $message->to(Config::get('mail.from')['address'], Config::get('mail.from')['name']);
                $message->replyTo($review->email, $review->name)
                    ->subject('Nuevo comentario en propiedad ' . $review->property_id);
            });
            /*
            $contact = $review->property->actions[0]->contact; //TODO if different actions for the same property has different contacts, then we have a problem
            if(preg_match_all(Config::get('app.mail_regex'),$contact->mail))
                Mail::send('mail.newcomment', ['review'=>$review], function($message) use ($review, $contact){
                    $message->from(Config::get('mail.from')['address'], Config::get('mail.from')['address']);
                    $message->to($contact->mail);
                    $message->replyTo($review->email, $review->name)
                        ->subject('Nuevo comentario a su propiedad en Habana Oasis');
                });
                */
        } catch (\Exception $e) {
            Log::error($e);
        }
        return back();
    }
    public function getContactenosUnlocalized(Request $request)
    {
        return $this->getContactenos($request, null);
    }
    public function getContactenos(Request $request, $lang)
    {
        if (App::getLocale() == 'es')
            return view('portal.contactus');
        else
            return view('portal.contactus-en');
    }
    public function postSendMail(Request $request)
    {
        $data = ['email' => $request->mail, 'texto' => $request->text];
        try {
            Mail::send('mail.generic', $data, function ($message) use ($data, $request) {
                $message->from(Config::get('mail.from')['address'], Config::get('mail.from')['address']);
                $message->to(Config::get('mail.from')['address'], Config::get('mail.from')['name']);
                $message->replyTo($request->email, '')
                    ->subject('Contacto por web');
            });
        } catch (\Exception $e) {
            Log::error($e);
        }
        return redirect(Helper::getPathFor('contactenos'));
    }
    public function postSendMailOwners(Request $request)
    {
        $data = ['email' => $request->mail, 'texto' => $request->text, 'address' => $request->address];
        $contact = Contact::find($request->contact);
        if (preg_match_all(Config::get('app.mail_regex'), $contact->mail) && preg_match_all(Config::get('app.mail_regex'), $request->email)) {
            try {
                Mail::send('mail.contactowner', $data, function ($message) use ($data, $contact, $request) {
                    $message->from(Config::get('mail.from')['address'], Config::get('mail.from')['address']);
                    $message->to($contact->mail);
                    $message->replyTo($request->email, '')
                        ->subject('Contacto por propiedad');
                });
            } catch (\Exception $e) {
                Log::error($e);
            }
        }
        return back();
    }
    public function getTos(Request $request, $lang, $apk = False)
    {
        if (App::getLocale() == 'es')
            return view('portal.tos', ['apk' => $apk]);
        else
            return view('portal.tos-en', ['apk' => $apk]);
    }

    public function getTosUnlocalized(Request $request, $apk = False)
    {
        return $this->getTos($request, null, $apk);
    }

    public function getNewSpecial(Request $request, $lang, $apk = False)
    {
        return view('create.special', ['apk' => $apk]);
    }

    public function getNewSpecialUnlocalized(Request $request, $apk = False)
    {
        return $this->getNewSpecial($request, null, $apk);
    }
}

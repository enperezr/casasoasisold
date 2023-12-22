<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Helper;
use App\Locality;
use App\Municipio;
use App\Property;
use App\PropertyFb;
use App\Action;
use App\PropertyAction;
use App\Image;
use App\MediaHelper;
use App\Registro;
use App\User;
use App\UserAction;
use App\Stat;
use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Mockery\CountValidator\Exception;

class PropertyController extends Controller
{
    public static $CONTACT_VALIDATION_KEY = 1;
    public static $PROPERTY_VALIDATION_KEY = 2;
    public static $IMAGES_VALIDATION_KEY = 3;

    private function saveImages($property, $data, $onlyImages = false)
    {
        $images = [];
        $imagesTotal = 0;
        foreach ($data as $key => $input) {
            if (starts_with($key, 'php')) {
                $images[$key] = $input;
                $imagesTotal++;
            }
        }
        if ($onlyImages)
            return $images;
        return ['message' => trans('messages.app.processing.images', ['total' => $imagesTotal]), 'images' => $images, 'property' => $property->id];
    }

    public function postProcessImages(Request $request)
    {
        $property = $request->property;
        $imageData = $request->images;
        $images = [];
        foreach ($imageData as $key => $input) {
            $localization = MediaHelper::proccessTmp($key, $property);
            $images[] = new Image([
                'localization' => $localization,
                'description' => $input
            ]);
        }
        $property = Property::findOrFail($property);
        $property->images()->saveMany($images);
        $property->has_images = true;
        $property->save();
        return count($images);
    }

    public function postSaveAll(Request $request)
    {
        $inm_data = [0]; //TODO Arreglar esto urgente
        foreach ($request->inmuebles as $inm) {
            parse_str($inm[0], $data);
            $municipio = Municipio::where('province_id', $data['province'])->where('id', $data['municipio'])->first();
            if (!$municipio)
                abort(400, 'El municipio no pertenece a la provincia');
            $inm_data[0] = $data;
        }
        parse_str($request->contact, $contact_arr);
        parse_str($request->action, $action_arr);
        //Detect or create anon user
        $user_id = null;
        $user = Auth::user();
        if ($user) {
            $user_id = Auth::user()->id;
        }
        if (!$user_id) {
            $user = $this->createUser();
            $user_id = $user->id;
        }
        //save contact data
        if (!array_has($contact_arr, 'gestor') or !$contact_arr['gestor']) {
            $contact = Helper::arrToObject(new Contact(), $contact_arr, ['_token', 'since', 'until', 'since-hour', 'until-hour', 'plan', 'gestor', 'provider']);
            // $contact->hours = $contact_arr['since-hour'].'-'.$contact_arr['until-hour'];
            //$contact->days = $contact_arr['since'].'-'.$contact_arr['until'];
            $contact->user_id = $user_id;
            $contact->save();
        } else { //when gestor is enabled the contact already exist in db, no need to save it
            $gestor = User::findOrFail($contact_arr['gestor']);
            $contact = $gestor->gestor_contact;
        }
        //init action or actions
        $action = Helper::arrToObject(new UserAction(), $action_arr, ['_token']);
        if ($action->action == 2) {
            $action1 = new UserAction();
            $action1->action_id = 2;
            $action1->frequency = null;
            $action1->description = $action->descriptionP;
            $action1->condition = $action->option;
            $action1->price = null;
            $action1->currency_id = null;
            $action1->user_id = $user_id;
        } else if ($action->action == 1) {
            $action1 = new UserAction();
            $action1->action_id = 1;
            $action1->frequency = null;
            $action1->description = $action->descriptionV;
            $action1->condition = null;
            $action1->price = $action->price;
            $action1->currency_id = $action->currency;
            $action1->user_id = $user_id;
        } else if ($action->action == 4) {
            $action1 = new UserAction();
            $action1->action_id = 1;
            $action1->price = $action->price;
            $action1->currency_id = $action->currency;
            $action1->description = $action->descriptionV;
            $action1->user_id = $user_id;
            $action2 = new UserAction();
            $action2->action_id = 2;
            $action2->condition = $action->option;
            $action2->description = $action->descriptionP;
            $action2->user_id = $user_id;
            $action2->price = null;
            $action2->currency_id = null;
        }
        //save actions
        if (isset($action1)) {
            $action1->contact_id = $contact->id;
            $action1->user_plan_id = $contact_arr['plan'];
            $action1->gestor = array_has($contact_arr, 'gestor') && $contact_arr['gestor'] ? $contact_arr['gestor'] : null;
            $action1->date = Carbon::now();
            $action1->save();
        }
        if (isset($action2)) {
            $action2->contact_id = $contact->id;
            $action2->user_plan_id = $contact_arr['plan'];
            $action2->gestor = array_has($contact_arr, 'gestor') && $contact_arr['gestor'] ? $contact_arr['gestor'] : null;
            $action2->date = Carbon::now();
            $action2->save();
        }

        //parse inmuebles data
        $inmuebles = array();
        $save_register = false;
        foreach ($inm_data as $data) {
            $property = Helper::arrToObject(new Property(), $data, [
                '_token', 'type', 'state', 'construction',
                'kitchen', 'province', 'municipio', 'locality', 'extra'
            ]);
            $property->property_type_id = $data['type'];
            $property->property_state_id = $data['state'];
            $property->construction_type_id = $data['construction'];
            $property->kitchen_type_id = $data['kitchen'];
            $property->province_id = $data['province'];
            $property->municipio_id = $data['municipio'];
            $localities = Locality::where('municipio_id', $property->municipio_id)->get();
            $localities_id = $localities->pluck('id');
            if ($localities_id->contains(function ($key, $value) use ($data) {
                return $value == $data['locality'];
            })) {
                $property->locality_id = $data['locality'];
            } else {
                foreach ($localities as $loc) {
                    if ($loc->name == 'unspecified')
                        $property->locality_id = $loc->id;
                }
            }
            $property->active = 0;
            $property->user_id = $user_id;
            $property->provider_id = array_has($contact_arr, 'provider') && $contact_arr['provider'] ? $contact_arr['provider'] : null;
            $property->date = Carbon::now();
            $property->gestor = array_has($contact_arr, 'gestor') && $contact_arr['gestor'] ? 1 : 0;

            //is new property?
            if ($property->id) {
                $save_register = true;
            }
            $property->save();
            if (isset($action1) && isset($action2)) {
                $property->actions()->sync([$action1->id, $action2->id]);
            } else if (isset($action1)) {
                $property->actions()->sync([$action1->id]);
            }

            if (array_has($data, 'extra')) {
                $commodities = [];
                foreach ($data['extra'] as $extra) {
                    $commodities[$extra] = ['created_at' => Carbon::now()];
                }
                $property->commodities()->sync($commodities);
            }
            $container = ['property' => $property, 'code' => $user->temporary];
            if (isset($inm[1])) {
                $container['images'][] = $this->saveImages($property, $inm[1], true);
            }
            $inmuebles[] = $container;
        }

        try {
            if (isset($action1) && isset($action2))
                $action = [$action1, $action2];
            Mail::send('mail.property', ['contact' => $contact, 'action' => $action, 'property' => $property, 'info' => $request->all()], function ($message) use ($contact) {
                $message->from(Config::get('mail.from')['address'], Config::get('mail.from')['name']);
                $message->to(Config::get('mail.from')['address'], Config::get('mail.from')['name'])
                    ->subject('Solicitud de nueva propiedad');
            });
            if (preg_match_all(Config::get('app.mail_regex'), $contact->mail)) {
                $template = 'mail.usercode';
                if (App::getLocale() == 'en')
                    $template = 'mail.usercode_en';
                Mail::send($template, ['code' => $user->temporary], function ($message) use ($contact) {
                    $message->from(Config::get('mail.from')['address'], Config::get('mail.from')['name']);
                    $message->to($contact->mail)
                        ->subject(trans('messages.app.user.message.subject'));
                });
            }
        } catch (\Exception $e) {
        } finally {
            return $inmuebles;
        }
    }

    //used in edition
    public function postSaveDataImages(Request $request)
    {
        $this->validateData(static::$PROPERTY_VALIDATION_KEY, $request);
        $this->validateData(static::$IMAGES_VALIDATION_KEY, $request);
        $property = $this->saveProperty($request->all());
        return $this->saveImages($property, $request->all());
    }

    private function saveProperty($data)
    {
        if ($data['id'] != '') {
            $property = Property::findOrFail($data['id']);
        } else {
            $property = new Property;
            $property->date = Carbon::today();
        }
        $property->surface = $data['surface'] ? $data['surface'] : 0;
        $property->rooms = $data['rooms'];
        $property->description = $data['description'];
        $property->baths = $data['baths'];
        $property->address = $data['address'];
        $property->floors = $data['floors'];
        $property->highness = $data['highness'];
        //$property->parcela = $data['parcela'] ? $data['parcela'] : 0;
        $property->property_type_id = $data['type'];
        $property->property_state_id = $data['state'];
        $property->construction_type_id = $data['construction'];
        $property->kitchen_type_id = $data['kitchen'];
        $property->province_id = $data['province'];
        $property->municipio_id = $data['municipio'];
        $property->locality_id = $data['locality'] ? $data['locality'] : $property->locality_id;
        $property->active = $property->active ? $property->active : 0;
        if (!$property->user_id)
            $property->user_id = Auth::user() ? Auth::user()->id : null;
        if (array_has($data, 'provider') && $data['provider'])
            $property->provider_id = $data['provider'];
        $property->save();
        if (array_has($data, 'extra')) {
            $commodities = [];
            foreach ($data['extra'] as $extra) {
                $commodities[$extra] = ['created_at' => Carbon::now()];
            }
            $property->commodities()->sync($commodities);
        }
        if (array_key_exists('apk', $data)) {
            Stat::where('name', 'apk_create_count')->increment('value');
        }
        return $property;
    }

    private function validateData($set, $request)
    {
        switch ($set) {
            case static::$CONTACT_VALIDATION_KEY:
                $this->validate($request, [
                    'names' => 'required_without:inmobiliaria|alpha_enumerator',
                    'phones' => 'required_without:inmobiliaria|numeric_enumerator',
                    'mail' => 'email',
                    'since-hour' => 'required_without:inmobiliaria|integer',
                    'until-hour' => 'required_without:inmobiliaria|integer',
                    'since' => 'required_without:inmobiliaria|integer',
                    'until' => 'required_without:inmobiliaria|integer'
                ]);
                break;
            case static::$PROPERTY_VALIDATION_KEY:
                $this->validate($request, [
                    //'address' => 'required',
                    'baths' => 'required_if:operation,comprar,permutar|integer',
                    'construction' => 'required|integer',
                    'floors' => 'required|integer',
                    //'frequency'=>'required_if:operation,rentar,alquilar',
                    //'operation'=>'in:comprar,permutar,rentar,alquilar',
                    'highness' => 'required|integer',
                    'kitchen' => 'required|integer',
                    'locality' => 'integer',
                    'municipio' => 'required|integer',
                    'option' => 'required_if:operation,permutar',
                    'parcela' => 'integer',
                    'price' => 'required_if:operation,comprar',
                    'province' => 'required|integer',
                    'rooms' => 'required|Numeric',
                    'state' => 'required|integer',
                    'surface' => 'required_if:operation,comprar,permutar|integer',
                    'type' => 'required|integer',
                ]);
                break;
            case static::$IMAGES_VALIDATION_KEY:
                break;
        }
    }

    public function createUser()
    {
        $pass = str_random();
        $user = new User();
        $user->temporary = $pass;
        $user->name = 'temporal';
        $user->email = $pass . '@habanaoasis.com';
        $user->password = $pass;
        $user->rol_id = 3;
        $user->save();
        return $user;
    }

    public function getAllFeedItems()
    {
        return Property::with('actions')->whereIn(
            'id',
            UserAction::select('id')
                ->where('concluded', 0)
                ->whereRaw('DATE_ADD(date, INTERVAL time DAY) < CURDATE()')
                ->get()
        )
            ->where('active', 1)
            ->orderBy('date', 'DESC')
            ->limit(200)
            ->get();
    }

    public function getAllFeedItemsForFb()
    {
        return PropertyFb::with('actions')->whereIn(
            'id',
            UserAction::select('id')
                ->where('concluded', 0)
                ->whereRaw('DATE_ADD(date, INTERVAL time DAY) < CURDATE()')
                ->get()
        )
            ->where('active', 1)
            ->orderBy('date', 'DESC')
            ->limit(200)
            ->get();
    }
}

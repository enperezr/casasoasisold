<?php

namespace App\Http\Controllers;

use App\Helper;
use App\MediaHelper;
use App\Plan;
use App\Rol;
use App\User;
use CURLFile;

use App\Contact;
use App\Image;
use App\Property;
use App\PropertyAdmin;
use App\Review;
use App\UserAction;
use App\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Registro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PropertyAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access:admin|moderador|agente|comercial');
    }

    public function getIndex()
    {
        if (Auth::getUser()->rol->name != 'agente')
            $properties = PropertyAdmin::getPropertiesForManagement(null, '', "published", 50);
        else
            $properties = PropertyAdmin::getAgentPropertiesForManagement(null, '', "published", 50);
        $allowed_rols = Rol::whereIn('name', ['admin', 'moderador'])->get();
        return view('admin.properties', ['properties' => $properties, 'user' => Auth::getUser(), 'allowed_rols' => $allowed_rols, 'currencies' => Currency::all()]);
    }

    public function getPropertyRepresentation(Request $request)
    {
        $property_id = $request->input('property_id');
        $property = Property::findOrfail($property_id);
        $allowed_rols = Rol::whereIn('name', ['admin', 'moderador'])->get();
        return view('admin.partials.trproperty', ['property' => $property, 'user' => Auth::getUser(), 'allowed_rols' => $allowed_rols]);
    }

    public function getImages(Request $request)
    {
        $id = $request->input('property_id');
        $images = Property::findOrFail($id)->images;
        return view('admin.partials.images', ['property_id' => $id, 'images' => $images]);
    }

    public function getAddImage(Request $request)
    {
        $property_id = $request->input('property_id');
        $imageTmp = $request->input('image');
        $property = Property::findOrFail($property_id);
        $localization = MediaHelper::proccessTmp($imageTmp, $property_id);
        $image = new Image();
        $image->localization = $localization;
        $property->images()->save($image);
        $property->has_images = true;
        $property->save();
        return view('admin.partials.singleimage', ['property_id' => $property_id, 'image' => $image]);
    }

    public function postSetImageDescription(Request $request)
    {
        $image_id = $request->input('image_id');
        $description = $request->input('description');
        $image = Image::findOrfail($image_id);
        $image->description = $description;
        $image->save();
        return $description;
    }

    public function postDeleteImage(Request $request)
    {
        $image_id = $request->input('image_id');
        $image = Image::findOrfail($image_id);
        try {
            unlink(public_path('images/properties/' . $image->property_id . '/' . $image->localization));
            unlink(public_path('images/properties/' . $image->property_id . '/30/' . $image->localization));
            unlink(public_path('images/properties/' . $image->property_id . '/50/' . $image->localization));
            unlink(public_path('images/properties/' . $image->property_id . '/70/' . $image->localization));
        } catch (\Exception $e) {
            Log::error($e);
        }
        $property = $image->property;
        $image->delete();
        if ($property->images->count() == 0) {
            $property->has_images = 0;
            $property->save();
        }
        return 1;
    }

    public function getComments(Request $request)
    {
        $property_id = $request->input('property_id');
        $property = Property::findOrFail($property_id);
        return view('admin.partials.comments', ['comments' => $property->reviews, 'property_id' => $property_id]);
    }

    public function postToggleReview(Request $request)
    {
        $review_id = $request->input('review_id');
        $review = Review::findOrFail($review_id);
        if ($review->published)
            $review->published = 0;
        else
            $review->published = 1;
        $review->save();
        return 1;
    }

    public function postDeleteReview(Request $request)
    {
        $review_id = $request->input('review_id');
        $review = Review::findOrFail($review_id);
        $review->delete();
        return 1;
    }

    public function getContacts(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $property_id = $request->input('property_id');
        $contact = Contact::findOrFail($contact_id);
        return view('admin.partials.contacts', ['contact' => $contact, 'property_id' => $property_id]);
    }

    public function postSetContact(Request $request)
    {
        $contact_id = $request->input('id');
        $contact = Contact::findOrFail($contact_id);
        $contact->names = $request->input('names');
        $contact->phones = $request->input('phones');
        $contact->mail = $request->input('email');
        $contact->save();
        return 1;
    }

    public function getActions(Request $request)
    {
        $property_id = $request->input('property_id');
        $property = Property::findOrFail($property_id);
        $actions = $property->actions;
        $currencies = Currency::All();
        return view('admin.partials.actions', ['property' => $property, 'actions' => $actions, 'currencies' => $currencies]);
    }

    public function postSetAction(Request $request)
    {
        $action_id = $request->input('id');
        $action = UserAction::findOrNew($action_id);
        if ($request->input('type')) {
            if ($action->action_id == 1) {
                $action->action_id = 2;
            } else {
                $action->action_id = 1;
            }
        }
        if (!$action->action_id) {
            $action->action_id = $request->input('action');
            $action->user_id = $request->user()->id;
        }

        if ($action->action_id == 1) {
            $action->price = $request->input('price_condition');
            $action->currency_id = $request->input('currency');
        } else {
            $action->condition = $request->input('price_condition');
        }

        $action->description = $request->input('description');

        if ($action->id)
            $action->save();
        else {
            $property = Property::findOrFail($request->input('property_id'));
            if ($property->actions->count()) {
                $contact = $property->actions[0]->contact_id;
                $action->contact_id = $contact;
            }
            $property->actions()->save($action);
        }

        return $action;
    }

    public function postDeleteAction(Request $request)
    {
        $property = Property::findOrFail($request->input('property_id'));
        $action = UserAction::findOrFail($request->input('action_id'));
        if ($property->actions->count() == 1)
            abort(400, "Can't delete the only action, try changeit or unpublish the property");
        $property->actions()->detach($action->id);
        $action->delete();
        return 1;
    }

    public function getDays(Request $request)
    {
        $property_id = $request->input('property_id');
        $property = Property::findOrFail($property_id);
        $actions = $property->actions;
        return view('admin.partials.days', ['property' => $property, 'actions' => $actions]);
    }

    public function postResetDays(Request $request)
    {
        $property_id = $request->input('property_id');
        $property = Property::findOrFail($property_id);
        $current = Carbon::now();
        $property->date = $current;
        $property->save();
        $actions = $property->actions;
        foreach ($actions as $action) {
            $action->date = $current;
            $action->save();
        }
        return ['calculate' => $actions[0]->time . ' days left from ' . $actions[0]->time, 'base_date' => Carbon::createFromFormat('Y-m-d H:i:s', $property->date)->format('Y/m/d')];
    }

    public function postAddDays(Request $request)
    {
        $property_id = $request->input('property_id');
        $days = $request->input('days');
        $property = Property::findOrFail($property_id);
        $daysPassed = \Carbon\Carbon::today()->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', $property->date));
        $available = $property->actions[0]->time - $daysPassed;
        if ($available < 0)
            $available = 0;
        $days += $available;
        $actions = $property->actions;
        $current = Carbon::now();
        $property->date = $current;
        $property->save();
        foreach ($actions as $action) {
            $action->time = $days;
            $action->date = $current;
            $action->save();
        }
        return ['calculate' => $actions[0]->time . ' days left from ' . $actions[0]->time, 'base_date' => Carbon::createFromFormat('Y-m-d H:i:s', $property->date)->format('Y/m/d')];
    }

    public function postToggleActive(Request $request)
    {
        if (Auth::getUser()->rol->name != 'admin' && Auth::getUser()->rol->name != 'moderador')
            abort(403);
        $property_id = $request->input('property_id');
        $property = Property::findOrFail($property_id);
        if ($property->active == 1)
            $property->active = 0;
        else
            $property->active = 1;
        $property->save();
        return 1;
    }

    public function postToggleConcluded(Request $request)
    {
        $property_id = $request->input('property_id');
        $property = Property::findOrFail($property_id);
        foreach ($property->actions as $action) {
            if ($action->concluded == 1)
                $action->concluded = 0;
            else
                $action->concluded = 1;
            $action->save();
        }
        return 1;
    }

    public function getSearch(Request $request)
    {
        $query = $request->input('query');
        $only = $request->input('only');
        $order = $request->input('order');
        if (Auth::getUser()->rol->name == 'agente')
            $properties = PropertyAdmin::getAgentPropertiesForManagement($query, $only, $order, null);
        else
            $properties = PropertyAdmin::getPropertiesForManagement($query, $only, $order, null);
        $allowed_rols = Rol::whereIn('name', ['admin', 'moderador'])->get();
        return view('admin.partials.multipletrproperty', ['properties' => $properties, 'user' => Auth::getUser(), 'allowed_rols' => $allowed_rols]);
    }

    public function getRevo(Request $request)
    {
        $property_id = $request->input('property_id');
        $property = Property::findOrFail($property_id);
        $action = $property->actions[0];
        return view('clasificados.revolico.presentation', ['property' => $property, 'action' => $action]);
    }

    public function postRevoSend(Request $request)
    {

        $images = $request->input('images');
        $property_id = $request->input('pid');
        $data = array(
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'price' => $request->input('price'),
            'email' => config('app.revo_mail'),
            'names' => $request->input('names'),
            'phones' => $request->input('phones'),
        );
        if ($images) {
            $imgs = explode(',', $images);
            foreach ($imgs as $img) {
                $data[$img] = new CURLFile(base_path('public/images/properties/' . $property_id . '/' . $img));
            }
        }

        //$f = fopen(storage_path('app/stderr.txt'), 'w');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('app.revo_endpoint'));
        //curl_setopt($ch, CURLOPT_HEADER, true);
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        //curl_setopt($ch, CURLOPT_STDERR, $f);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($ch, CURLOPT_USERPWD, 'remoto:remoto');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        //fclose($f);
        curl_close($ch);
        if ($result == 'OK') {
            $property = Property::findOrFail($property_id);
            $prom = $property->promocioned;
            if (!str_contains($prom, 'rev')) {
                $prom .= 'rev';
                $property->promocioned = $prom;
                $property->save();
            }
            return '1';
        }
        return $result;
    }

    public function postDelete(Request $request)
    {
        $pid = $request->input('property_id');
        $property = Property::findOrFail($pid);

        if (Auth::getUser()->rol->name != 'admin' && Auth::getUser()->rol->name != 'moderador')
            abort(403);
        elseif (Auth::getUser()->rol->name == 'moderador' && $property->plan_id != 0)
            abort(403);

        $property->reviews()->delete();
        $property->rates()->delete();
        $property->images()->delete();
        foreach ($property->actions as $action) {
            if (!$property->gestor)
                $action->contact()->delete();
            if ($action->user->properties->count() < 2 && $action->user->rol->name == 'propietario')
                $action->user()->delete();
        }
        $property->actions()->delete();
        $property->delete();
        try {
            Helper::rrmdir('public/images/properties/' . $pid);
        } catch (\ErrorException $e) {
        }
        return 1;
    }

    public function postSetImageFront(Request $request)
    {
        $id = $request->input('image_id');
        $image = Image::findOrFail($id);
        Image::where('property_id', $image->property_id)->where('id', '!=', $id)->update(['front' => 0]); //set others to 0
        $image->front = abs($image->front - 1);
        $image->save();
        if ($image->front)
            return 1;
        else
            return 2;
    }

    public function getRenovate(Request $request)
    {
        if (Auth::user()->rol->name != 'admin' && Auth::user()->rol->name != 'moderador')
            abort(403);
        $property_id = $request->input('property_id');
        $property = Property::findOrFail($property_id);
        $actions = $property->actions;
        $plans = Plan::where('active', 1)->get();
        $providers = User::getProviders();
        return view('admin.partials.renovation', ['property' => $property, 'actions' => $actions, 'plans' => $plans, 'providers' => $providers]);
    }

    public function postRenovate(Request $request)
    {
        if (Auth::user()->rol->name != 'admin' && Auth::user()->rol->name != 'moderador')
            abort(403);
        $plan_id = $request->input('plan');
        $plan = Plan::findOrFail($plan_id);
        $provider_id = $request->input('provider');
        if ($provider_id)
            $provider = User::findOrFail($provider_id);
        else
            $provider = null;
        $property_id = $request->input('id');
        $property = Property::findOrFail($property_id);

        //add Days
        $daysPassed = \Carbon\Carbon::today()->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', $property->date));
        $available = $property->actions[0]->time - $daysPassed;
        if ($available < 0)
            $available = 0;
        $days = $plan->days + $available + 7; //add 7 gift days
        $actions = $property->actions;
        $current = Carbon::now();
        $property->date = $current;

        $register_type = 'renew';
        if (!$property->plan_id) {
            $property->plan_id = $plan->id;
            $register_type = 'new';
        }

        if ($property->user->rol->name == "propietario") { //update owner before save
            $current = $property->user->id;
            UserAction::whereIn('id', $actions->pluck('id'))->update(['user_id' => Auth::user()->id]); //set user to actions
            foreach ($actions as $action) {
                $action->contact()->update(['user_id' => Auth::user()->id]);
            }
            $property->user_id = Auth::user()->id;
            $property->save();
            User::find($current)->delete();
        } else {
            $property->save();
        }

        foreach ($actions as $action) {
            $action->time = $days;
            $action->date = Carbon::now();
            $action->save();
        }
        //update asientos
        $asiento = new Registro();
        $asiento->registerer = Auth::user()->id;
        $asiento->provider = $provider_id ? $provider_id : NULL;
        $asiento->plan_id = $plan->id;
        $asiento->type = $register_type;
        $asiento->property_id = $property->id;
        $asiento->payment_via = $request->input('payment');
        $asiento->real_m = $request->input('real') ? $request->input('real') : NULL;
        $asiento->note = $request->input('note');
        $asiento->save();
        return $property;
    }
}

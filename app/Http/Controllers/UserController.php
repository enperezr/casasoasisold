<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 05/08/2015
 * Time: 13:15
 */

namespace app\Http\Controllers;

use App\Action;
use App\Commodity;
use App\Contact;
use App\Http\Controllers\Controller;
use App\Image;
use App\Property;
use App\Service;
use App\StateConstruction;
use App\TypeConstruction;
use App\TypeKitchen;
use App\TypeProperty;
use App\User;
use App\Province;
use App\Municipio;
use App\Locality;
use App\UserAction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('access:owner');
    }

    public function getDashboard(Request $request){
        $user = $request->user();
        $properties = $user->properties;
        $actions = $user->actions;
        $contacts = $user->contacts;
        return view('user.dashboard', ['properties'=>$properties, 'actions'=>$actions, 'contacts'=>$contacts]);
    }

    public function getLogout(Request $request){
        Auth::logout();
        return redirect('/auth/login');
    }

    public function createProperty(Request $request){
        $provinces = Province::cachedAll();
        $types = TypeProperty::cachedAll();
        $states = StateConstruction::cachedAll();
        $constructions = TypeConstruction::cachedAll();
        $kitchen = TypeKitchen::cachedAll();
        $commodities = Commodity::cachedAll();
        $municipios = Municipio::where('province_id', $provinces[0]->id)->get();
        $localities = Locality::where('municipio_id', $municipios[0]->id)->get();
        $data = [
            'provinces'=>$provinces,
            'municipios'=>$municipios,
            'localities'=>$localities,
            'types'=>$types,
            'states'=>$states,
            'constructions'=>$constructions,
            'kitchen'=>$kitchen,
            'commodities'=>$commodities,
        ];
        return view('create.inmueble', $data);
    }

    public function createAction(Request $request){
        $id = $request->input('id');
        $actionObject = UserAction::findOrNew($id);
        $data = [
            'types'=>Action::cachedAll(),
            'services'=>Service::cachedAll(),
            'action'=>$actionObject
        ];
        return view('create.action', $data);
    }

    public function createContact(Request $request){
        $id = $request->input('id');
        $contactObject = Contact::findOrNew($id);
        return view('create.contact', ['contact'=>$contactObject]);
    }

    public function postSaveAction(Request $request){
        $id = $request->input('id');
        $action = $request->input('action');
        $price = $request->input('price');
        $option = $request->input('option');
        $frequency = $request->input('frequency');
        //$time = $request->input('time');
        $services = $request->input('services');
        $description = $request->input('description');
        $concluded = $request->input('concluded');
        $actionObject = UserAction::findOrNew($id);
        $actionObject->description = $description;
        $actionObject->action_id = $action;
        $actionObject->time = 0;
        $actionObject->concluded = $concluded;
        $actionObject->user_id = Auth::user()->id;
        switch($action){
            case 1:
                $actionObject->price = $price;
                break;
            case 2:
                $actionObject->condition = $option;
                break;
            default:
                $actionObject->price = $price;
                $actionObject->frequency = $frequency;
        }
        $actionObject->save();
        if(count($services) > 0)
            $actionObject->services()->attach($services, ['action_id'=>$action, 'created_at'=>Carbon::now()]);
        return redirect('user/dashboard');
    }

    public function postSaveContact(Request $request){
        $id = $request->input('id');
        $contactObject = Contact::findOrNew($id);
        $contactObject->user_id = Auth::user()->id;

        $names = $request->input('names');
        $phones = $request->input('phones');
        $mail = $request->input('mail');
        $since_hour = $request->input('since-hour');
        $until_hour = $request->input('until-hour');
        $since = $request->input('since');
        $until = $request->input('until');

        $contactObject->names = $names;
        $contactObject->phones = $phones;
        $contactObject->mail = $mail;
        $contactObject->hours = $since_hour.'-'.$until_hour;
        $contactObject->days = $since.'-'.$until;

        $contactObject->save();
        return redirect('user/dashboard');
    }

    public function postDeleteAction(Request $request){
        $id = $request->input('id');
        $action = UserAction::findOrFail($id);
        if($action->delete())
            return 1;
        return 0;
    }

    public function postDeleteProperty(Request $request){
        $id = $request->input('id');
        $property = Property::findOrFail($id);
        if($property->delete())
            return 1;
        return 0;
    }

    public function postDeleteContact(Request $request){
        $id = $request->input('id');
        $contact = Contact::findOrFail($id);
        if($contact->delete())
            return 1;
        return 0;
    }

    public function postDetachProperty(Request $request){
        $pid = $request->input('property');
        $aid = $request->input('action');
        $action = UserAction::findOrFail($aid);
        if($action->properties()->detach($pid))
            return 1;
        return 0;
    }

    public function postDetachContact(Request $request){
        $cid = $request->input('contact');
        $aid = $request->input('action');
        $action = UserAction::findOrFail($aid);
        $action->contact_id = null;
        if($action->save())
            return 1;
        return 0;
    }

    public function postAttachProperty(Request $request){
        $pid = $request->input('property');
        $aid = $request->input('action');
        $action = UserAction::findOrFail($aid);
        if($action->properties()->attach($pid))
            return 1;
        return 0;
    }

    public function postAttachContact(Request $request){
        $cid = $request->input('contact');
        $aid = $request->input('action');
        $action = UserAction::findOrFail($aid);
        $action->contact_id = $cid;
        $action->save();
        return 1;
    }

    public function modifyProperty($lang = null, $id){        
        $property = Property::findOrFail($id);
        $provinces = Province::cachedAll();
        $types = TypeProperty::cachedAll();
        $states = StateConstruction::cachedAll();
        $constructions = TypeConstruction::cachedAll();
        $kitchen = TypeKitchen::cachedAll();
        $commodities = Commodity::cachedAll();
        $municipios = Municipio::where('province_id', $property->province_id)->get();
        $localities = Locality::where('municipio_id', $property->municipio_id)->get();
        $data = [
            'property'=>$property,
            'provinces'=>$provinces,
            'municipios'=>$municipios,
            'localities'=>$localities,
            'types'=>$types,
            'states'=>$states,
            'constructions'=>$constructions,
            'kitchen'=>$kitchen,
            'commodities'=>$commodities
        ];
        return view('create.inmueble', $data);
    }

    public function modifyContact($id){
        $contactObject = Contact::findOrFail($id);
        return view('create.contact', ['contact'=>$contactObject]);
    }

    public function modifyAction($id){
        $actionObject = UserAction::findOrFail($id);
        $data = [
            'types'=>Action::cachedAll(),
            'services'=>Service::cachedAll(),
            'action'=>$actionObject
        ];
        return view('create.action', $data);
    }

    public function postDeleteImage(Request $request){
        $id = $request->input('id');
        $image = Image::findOrFail($id);
        unlink(public_path('images/properties/'.$image->property_id.'/'.$image->localization));
        unlink(public_path('images/properties/'.$image->property_id.'/30/'.$image->localization));
        unlink(public_path('images/properties/'.$image->property_id.'/50/'.$image->localization));
        unlink(public_path('images/properties/'.$image->property_id.'/70/'.$image->localization));
        $image->delete();
        return 1;
    }


    public function construction(){
        return view('errors.under_construction');
    }
}

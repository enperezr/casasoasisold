<?php

namespace App\Console\Commands;

use App\Commodity;
use App\Contact;
use App\GroupTypesProperty;
use App\Municipio;
use App\PropertyAction;
use App\Province;
use App\Service;
use App\TypeProperty;
use App\User;
use App\Image;
use Illuminate\Console\Command;
use Eden\Mail\Imap;
use Illuminate\Support\Facades\Config;
use App\MediaHelper;
use App\Property;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MailPublisher extends Command{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search mail for properties to publish';

    /**
     * Imap connection
     * @var null
     */
    protected $imap = null;
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(!$this->imap){
            $this->imap = Imap::i(Config::get('mail.imap_host'), Config::get('mail.imap_user'), Config::get('mail.imap_pass'), Config::get('mail.imap_port'), Config::get('mail.imap_ssl'));
            $this->imap->setActiveMailbox(Config::get('mail.imap_inbox'));
        }
        $messages = $this->loadMessages();
        foreach($messages as $message){
            $uid = $message['uid'];
            $details = $this->imap->getUniqueEmails($uid, true);
            $this->processData($details); //TODO all messages has text/plain part?
            $this->imap->move($uid, Config::get('mail.imap_junk'));
        }
        $this->imap->expunge();
        $this->imap->disconnect();
        $this->imap = null;
    }

    public function loadMessages(){

        $messages = $this->imap->search(array('SUBJECT "'.Config::get('app.MAIL_KEY_POST').'"'));
        if(isset($messages['uid'])){
            $messages = array($messages);
        }
        return $messages;
    }

    public function processData($data){
        $images = [];
        foreach($data['attachment'] as $name=>$file){
            //TODO check if is an image, in other case, do not save
            file_put_contents(public_path('images/tmp/').$name, implode(PHP_EOL, $file));
            $images[] = $name;
        }
        $parsed = json_decode($data['body']['text/plain'], true);
        if(json_last_error() == JSON_ERROR_NONE){
            $this->saveFromMail($parsed, $images, $data['from']);
        }
        else{
            $this->sendMailErrorResponse($data['from'], json_last_error_msg(), "JSON ERROR");
            print_r(json_last_error_msg());
        }
    }

    /**
     * Creates a property from data gathered from an email.
     * The email is expected to have a json with text-data in the body, and a number of attached images
     * @param $data
     * @param $images
     * @param $sender
     */
    public function saveFromMail($data, $images, $sender){
        $rules = array_merge(Property::$rules, PropertyAction::$rules);
        //make sure contact is defined
        $rules['inmobiliaria'] = 'integer|exists:contacts,id';
        if(!isset($data['inmobiliaria']) || !$data['inmobiliaria']){
            $rules = array_merge($rules, Contact::$rules);
        }
        if(!isset($data['province_id']) || !$data['province_id']
            || !isset($data['municipio_id']) || !$data['municipio_id']
            || !isset($data['locality_id']) || !$data['locality_id'])
        {
            $this->sendMailErrorResponse($sender, ['localization'=>'provincia, municipio o localidad no definida'], 'VALIDATION ERROR', $data);
            print 'provincia, municipio o localidad no definida';
            return;
        }
        $validator = Validator::make($data, $rules);
        //specific validation logic
        $validator->after(function($validator) use ($data){
            if(!Province::findOrNew($data['province_id'])->municipios->contains('id', $data['municipio_id'])
                || ($data['locality_id'] && !Municipio::findOrNew($data['municipio_id'])->localities->contains('id', $data['locality_id']))){
                $validator->errors()->add('localization', 'province, municipio or locality not corresponding between them');
            }
        });

        if($validator->fails()){
            $this->sendMailErrorResponse($sender, $validator->errors(), 'VALIDATION ERROR', $data);
            print_r($validator->errors());
            return;
        }

        //special fields to be handled only by administrators
        $data['user_id'] = null;
        $data['active'] = 0;
        $data['highlighted'] = 0;

        //check if this mail user is an administrator
        if(isset($data['identity'])){
            $user = User::where('mail_identity',$data['identity'])->first();
            if($user){
                $data['user_id'] = $user->id;
                $data['active'] = 1;
            }
        }

        //property create
        $property = Property::create([
            'surface'=>$data['surface'],
            'rooms'=>$data['rooms'],
            'baths'=>$data['baths'],
            'address'=>$data['address'],
            'floors'=>$data['floors'],
            'highness'=>$data['highness'],
            'parcela'=>$data['parcela'],
            'property_type_id'=>$data['property_type_id'],
            'construction_type_id'=>$data['construction_type_id'],
            'property_state_id'=>$data['property_state_id'],
            'kitchen_type_id'=>$data['kitchen_type_id'],
            'province_id'=>$data['province_id'],
            'municipio_id'=>$data['municipio_id'],
            'locality_id'=>$data['locality_id'],
            'user_id'=>$data['user_id'],
            'active'=>$data['active'],
            'highlighted'=>$data['highlighted'],
            'date' => Carbon::today()
        ]);

        //add extras
        if(is_array($data['extras']) && !empty($data['extras'])){
            $groups = [TypeProperty::findOrNew($data['property_type_id'])->group_id, GroupTypesProperty::$COMODIN];
            $commodities = Commodity::cachedAll();
            $to_save = [];
            foreach($data['extras'] as $extra){
                if(!$commodities->contains('id', $extra)
                    || !in_array($commodities->where('id', $extra)->first()->group_id, $groups))
                    continue;
                $to_save[$extra] = ['created_at' => Carbon::now()];

            }
            $property->commodities()->attach($to_save);

        }

        //select/save contact
        if(isset($data['inmobiliaria']) && $data['inmobiliaria'] != null){
            $contact = Contact::findOrNew($data['inmobiliaria']);
        }
        else{
            $contact = Contact::create([
                'names'=>$data['names'],
                'phone'=>$data['phones'],
                'mail'=>$data['mail'],
                'hours'=>$data['hours'],
                'days'=>$data['days']
            ]);
        }

        //add action
        $action_data = [
            'description'=>$data['description'],
            'created_at'=>Carbon::now(),
            'contact_id'=>$contact->id,
            'protected_by'=>$data['inmobiliaria']
        ];


        switch($data['operation']){
            case 1:
                $action_data['price'] = $data['price'];
                break;
            case 2:
                $action_data['permuta'] = $data['option'];
                break;
            default:
                $action_data['price'] = $data['price'];
                $action_data['frequency'] = $data['frequency'];

        }

        $property->actions()->attach($data['operation'], $action_data);

        //add services offered if operation is rent
        if($data['operation'] == 3){
            if(is_array($data['services']) && !empty($data['services'])) {
                $action_property = PropertyAction::where('property_id', $property->id)->where('action_id', $data['operation'])->first();
                $services = Service::cachedAll();
                $to_save = [];
                foreach ($data['services'] as $s) {
                    if($services->contains('id', $s)) {
                        $to_save[$s] = ['property_id' => $property->id, 'action_id' => $action_property->action_id, 'created_at' => Carbon::now()];
                    }
                }
                $action_property->services()->attach($to_save);
            }
        }

        //process images
        $to_save = [];
        foreach($images as $img) {
            $id = explode('.',$img);
            $localization = MediaHelper::proccessTmp($id[0], $property->id);
            $to_save[] = new Image([
                'localization' => $localization,
                'description' => isset($data[$img]) ? $data[$img] : null
            ]);
        }
        $property->images()->saveMany($to_save);

        $this->sendMailSuccessResponse($sender, $property, $contact, $data);
    }


    public function sendMailErrorResponse($dst, $errors, $type, $info=false){
        $data = [
            'data'=>$info,
            'errors'=>$errors,
            'type'=>$type
        ];
        Mail::send('mail.publish_error', $data, function($message) use ($data, $dst){
            $message->from(Config::get('mail.from')['address'], Config::get('mail.from')['name']);
            $message->to($dst['email'], $dst['name'])->subject('Error Creando Propiedad');
        });
    }

    public function sendMailSuccessResponse($dst, $property, $contact, $info){
        $data = [
            'property'=>$property,
            'action'=>$info['operation'],
            'propertyAction'=>PropertyAction::where('property_id', $property->id)->where('action_id', $info['operation'])->first(),
            'contact'=>$contact,
            'data'=>$info
        ];
        Mail::send('mail.publish_success', $data, function($message) use ($data, $dst){
            $message->from(Config::get('mail.from')['address'], Config::get('mail.from')['name']);
            $message->to($dst['email'], $dst['name'])->subject('Confirmación de propiedad creada');
        });
    }

}
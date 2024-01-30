<?php

namespace App\Http\Controllers;

use App\Helper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Property;
use App\PropertyAction;
use App\TypeError;
use Illuminate\Support\Facades\Config;

class MailController extends Controller
{

    public function postSendError(Request $request){
        $data = [
            'property' => Property::findOrFail($request->property),
            'action'=> PropertyAction::findOrFail($request->action)->action,
            'reporte'=>TypeError::findOrFail($request->reporte)
        ];
        Mail::send('mail.errors', $data, function($message) use ($request){
            $message->from('acromeu@rhc.cu', 'Alejandro Pérez');
            $message->to('acromeu@rhc.cu', 'Alejandro Pérez')->subject('Reporte de error');
        });
        return 'OK';
    }

    public function postSendMessage(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|email',
            'comment'=>'required',
            'property'=>'required|integer',
            'action'=>'required|integer'
        ]);
        $property = Property::findOrFail($request->property);
        $action = PropertyAction::findOrFail($request->action);
        $data = [
            'property'=>$property,
            'action'=>$action,
            'name' => $request->name,
            'email'=> $request->email,
            'comment'=>$request->comment,
        ];
        Mail::send('mail.requests', $data, function($message) use ($data){
            $message->from($data['email'], $data['email']);
            $message->to(Config::get('mail.from')['address'], Config::get('mail.from')['name'])
                ->subject('Solicitud de Información');
        });
        return 'OK';
    }

    public function getTestMail(){
        //Helper::checkMail();
        print_r(explode('=', ''));
    }

}

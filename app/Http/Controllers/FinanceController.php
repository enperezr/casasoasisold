<?php

namespace App\Http\Controllers;

use App\Commission;
use App\Notification;
use App\Plan;
use App\Registro;
use App\Rol;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access:admin|moderador');
    }

    public function getIndex(Request $request){
        $plans = Plan::all();
        $rols = Rol::where('assignable', 1)->get();
        $coms = Commission::all();
        $commissions = [];
        foreach ($coms as $c){
            if(!isset($commissions[$c->rol_id]))
                $commissions[$c->rol_id] = [];
            $commissions[$c->rol_id][$c->plan_id] = $c;
        }
        return view('admin.finances', ['rols'=>$rols, 'plans'=>$plans, 'commissions'=>$commissions]);
    }

    public function savePlan(Request $request){
        $price = $request->input('price');
        $days = $request->input('days');
        if($request->has('id')){
            $plan = Plan::findOrFail($request->input('id'));
        }
        else{
            $plan = new Plan;
        }
        $plan->price = $price;
        $plan->days = $days;
        $plan->save();
        return Plan::all();
    }

    public function togglePlan(Request $request){
        $plan = Plan::findOrFail($request->input('id'));
        $plan->active = abs($plan->active - 1);
        $plan->save();
        return $plan;
    }

    public function deletePlan(Request $request){
        $plan = Plan::findOrFail($request->input('id'));
        if($plan->properties->count() == 0){
            $plan->delete();
        }
        else{
            abort(400, 'There are '.$plan->properties->count().' properties with this plan');
        }
        return Plan::all();
    }

    public function calculate(Request $request){
        $from = $request->input('from');
        $to = $request->input('to');
        $registros = Registro::whereBetween('created_at', [$from, $to])->get();
        $resumeAndTotal = Registro::getResume($registros);
        return view('admin.finances-calc', ['registers'=> $registros, 'resumeAndTotal'=>$resumeAndTotal,'from'=>$from, 'to'=>$to]);
    }

    public function saveCommission(Request $request){
        $plan = $request->input('plan');
        $rol = $request->input('rol');
        $value = $request->input('value');
        $commission = Commission::where('rol_id', $rol)->where('plan_id', $plan)->first();
        if(!$commission){
            $commission = new Commission;
            $commission->rol_id = $rol;
            $commission->plan_id = $plan;
        }
        $commission->value = $value;
        $commission->save();
        return $commission;
    }

    public function getNotificationResponse(Request $request){
        $property = $request->input('property');
        $notification = Notification::where('property_id', $property)->first();
        if($notification)
            return $notification->cause;
        return 0;
    }

    public function getSaveNotification(Request $request){
        $property = $request->input('property');
        $cause = $request->input('cause');
        $attempts = $request->input('attempt');
        $notification = Notification::where('property_id', $property)->first();
        if(!$notification)
            $notification = new Notification;
        $notification->property_id = $property;
        $notification->cause = $cause;
        if($attempts){
            if($notification->attempts)
                $notification->attempts +=1;
            else
                $notification->attempts = 1;
        }
        $notification->save();
        return $notification;
    }
}

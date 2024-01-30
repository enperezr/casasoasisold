<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table = 'asientos';

    public function registerer_relation(){
        return $this->belongsTo('App\User', 'registerer');
    }

    public function provider_relation(){
        return $this->belongsTo('App\User', 'provider');
    }

    public function property(){
        return $this->belongsTo('App\Property', 'property_id');
    }

    public function plan(){
        return $this->belongsTo('App\Plan');
    }

    public static function getResume($registers){
        $resume = [];
        $payments = [];
        foreach ($registers as $register){
            if(isset($payments[$register->payment_via])){
                $payments[$register->payment_via] += ($register->real_m ? $register->real_m : $register->plan->price);
            }
            else{
                $payments[$register->payment_via] = ($register->real_m ? $register->real_m : $register->plan->price);
            }
            if($register->provider){
                $provider = $register->provider_relation;
            }
            else{
                $provider = $register->registerer_relation;
            }
            if(!isset($resume[$provider->id])){
                $resume[$provider->id] = [];
            }
            $resume[$provider->id]['provider'] = $provider;
            if(isset($resume[$provider->id][$register->type])){
                if(isset($resume[$provider->id][$register->type][$register->plan->id])){
                    $resume[$provider->id][$register->type][$register->plan->id]++;
                }
                else
                    $resume[$provider->id][$register->type][$register->plan->id] = 1;
                }
            else{
                $resume[$provider->id][$register->type] = [];
                $resume[$provider->id][$register->type][$register->plan->id] = 1;
            }
            if(isset($resume[$provider->id]['total'])){
                $resume[$provider->id]['total'] += ($register->real_m ? $register->real_m : $register->plan->price);
            }
            else{
                $resume[$provider->id]['total'] = ($register->real_m ? $register->real_m : $register->plan->price);
            }
            if(isset($resume[$provider->id]['commissions'])){
                $resume[$provider->id]['commissions'] += ($register->real_m ? 0 : $register->plan->getCommission($provider->rol)->value);
            }
            else{
                $resume[$provider->id]['commissions'] = ($register->real_m ? 0 : $register->plan->getCommission($provider->rol)->value);
            }

                $resume[$provider->id]['net'] = $resume[$provider->id]['total'] - $resume[$provider->id]['commissions'];


        }
        $totals = ['new'=>[], 'renew'=>[], 'total'=>0, 'commissions'=>0, 'net'=>0];

        foreach ($resume as $res){
            $totals['total'] += $res['total'];
            $totals['commissions'] += $res['commissions'];
            $totals['net'] += $res['net'];
            if(isset($res['new'])){
                foreach ($res['new'] as $k=>$v){
                    if(isset($totals['new'][$k])){
                        $totals['new'][$k] += $v;
                    }
                    else{
                        $totals['new'][$k] = $v;
                    }
                }
            }
            if(isset($res['renew'])){
                foreach ($res['renew'] as $k=>$v){
                    if(isset($totals['renew'][$k])){
                        $totals['renew'][$k] += $v;
                    }
                    else{
                        $totals['renew'][$k] = $v;
                    }
                }
            }

        }
        return ['resume'=>$resume, 'totals'=>$totals, 'payments'=>$payments];
    }
}

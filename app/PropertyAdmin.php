<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PropertyAdmin extends Property
{
    /**
     * @param $filters
     *      These filters are for equals operations and they will work across relations
     *          accepted filters are province, municipio, locality, is_venta, is_permuta, is_expired, is_almost_expired
     *          active, inactive, user_code, username, contact_name
     * @param $ordering
     *
     *      Ordering is accepted for is_permuta, is_venta, price, is_active, days_left, updated_date, username,
     *          contact_name
     * @param $pagination
     */
    public static function getPropertiesForManagement($search, $filters, $ordering, $pagination){

        //prepare join statement
        $query = Property::select('properties.*')->distinct('id');
        $query->join('properties_actions', 'properties.id', '=', 'properties_actions.property_id');
        $query->join('user_actions', 'user_actions.id', '=', 'properties_actions.user_action_id');
        //$query->join('currencies', 'currencies.id', '=', 'user_actions.currency_id');
        $query->join('contacts', 'user_actions.contact_id', '=', 'contacts.id');
        $query->join('users', 'user_actions.user_id', '=', 'users.id');

        if($search){
            $query->join('provinces', 'properties.province_id', '=', 'provinces.id');
            $query->join('municipios', 'properties.municipio_id', '=', 'municipios.id');
            $query->leftjoin('localities', 'properties.locality_id', '=', 'localities.id');
            $query->where(function($query) use($search){
                $query->where('properties.id', '=', $search);
                $query->orWhere('users.name', 'like', '%'.trim($search).'%');
                $query->orwhere('users.temporary', 'like', '%'.trim($search).'%');
                $query->orwhere('contacts.names', 'like', '%'.trim($search).'%');
                $query->orwhere('contacts.phones', 'like', '%'.trim($search).'%');
                $query->orwhere('provinces.name', 'like', '%'.trim($search).'%');
                $query->orwhere('municipios.name', 'like', '%'.trim($search).'%');
                $query->orwhere('localities.name', 'like', '%'.trim($search).'%');
            });
        }
        if($filters){
            if(str_contains($filters,'INACTIVE')){
                $query->where('properties.active', '=', 0);
            }
            if(str_contains($filters,'ACTIVE')){
                $query->where('properties.active', '=', 1);
            }
            if(str_contains($filters,'CONCLUDED')){
                $query->where('user_actions.concluded', '=', 1);
            }
            if(str_contains($filters,'UNCONCLUDED')){
                $query->where('user_actions.concluded', '=', 0);
            }
            if(str_contains($filters,'VENTA')){
                $query->where('user_actions.action_id', '=', 1);
            }
            if(str_contains($filters,'PERMUTA')){
                $query->where('user_actions.action_id', '=', 2);
            }
            if(str_contains($filters,'AGENT')){
                $query->where('users.id', '=', Auth::getUser()->id);
            }
            if(str_contains($filters,'GESTOR')){
                $query->where('properties.gestor', '=', 1);
            }
        }
        if($ordering == 'images'){
            $query->orderby('properties.has_images', 'DESC');
        }
        elseif($ordering == 'published'){
            $query->orderby('properties.created_at', 'DESC');
        }
        //print_r($query->toSql());exit();
        //add pagination
        if($pagination)
            return $query->paginate($pagination);
        $result = $query->with('images', 'reviews', 'actions', 'province', 'municipio')->get();
        if($ordering == 'expiring'){
            $result = $result->sort(function($a, $b){
                $daysPassed = \Carbon\Carbon::today()->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', $a->date));
                $a_time_av = $a->actions[0]->time - $daysPassed;
                $daysPassed = \Carbon\Carbon::today()->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', $b->date));
                $b_time_av = $b->actions[0]->time - $daysPassed;
                return $a_time_av - $b_time_av;
            });
        }
        elseif($ordering == 'comments'){
            $result = $result->sort(function($a, $b){
                return ($b->reviews->count() - $a->reviews->count());
            });
        }
        return $result;
    }

    public static function getAgentPropertiesForManagement($search, $filters, $ordering, $pagination){
        $filters.=',AGENT';
        return PropertyAdmin::getPropertiesForManagement($search, $filters, $ordering, $pagination);
    }

    /**
     * @param $days
     *   Get the properties that has expired within the last $days days
     * @return Collection
     */
    public static function getExpiredLastDays($days){
        $command = Property::select('properties.*')->with('actions')
            ->join('properties_actions', 'properties.id', '=', 'properties_actions.property_id')
            ->join('user_actions', 'properties_actions.user_action_id', '=', 'user_actions.id')
            ->where('active', 1)
            ->where(DB::raw('ADDDATE(properties.date, user_actions.time)'), '<=', DB::raw('CURDATE()'))
            ->groupBy('properties.id')
            ->orderBy('properties.date');
        if(is_numeric($days)){
            $command->where(DB::raw('ADDDATE(properties.date, user_actions.time)'), '>=', DB::raw('SUBDATE(CURDATE(), '.$days.')'));
        }
        $expireds = $command->paginate(15);
        return $expireds;
    }
}

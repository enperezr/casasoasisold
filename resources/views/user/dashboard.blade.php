@section('styles')
    <link rel="stylesheet" href="{{asset('css/forms.css')}}">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('js/validator.js')}}"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>
@endsection
@extends('layout.master')
@section('title', trans('messages.app.user.panel'))
@section('content')
    <div class="row clearfix">
        <a class="button logout pull-right" href="{{\App\Helper::getPathFor('user/logout')}}" title="{{trans('messages.app.user.logout')}}">{{trans('messages.app.auth.as')}} {{Auth::user()->name}}</a>
        @if(Auth::user()->rol_id == 2)
            <a class="button as_admin pull-right" href="{{\App\Helper::getPathFor('admin/dashboard')}}">Admin DASHBOARD</a>
        @endif
    </div>
    <div class="row white-block ">
        <div class="twelve columns">
            <h4>{{trans_choice('messages.words.contact', $contacts->count())}}</h4>
        </div>
        <div class="twelve columns">
            @if($contacts->count() == 0)
                <h6>{{trans('messages.app.no.contacts')}}</h6>
            @else
                @foreach($contacts as $contact)
                    @include('shared.userContact',['contact'=>$contact])
                @endforeach
            @endif
        </div>
        <div class="twelve columns">
            <a class="button" href="{{\App\Helper::getPathFor('user/create/contact')}}">{{trans('messages.actions.add.contact')}}</a>
        </div>
        <hr />
        <div class="twelve columns">
            <h4>{{trans_choice('messages.words.property', $properties->count())}}</h4>
        </div>
        <div class="twelve columns">
            @if($properties->count() == 0)
                <h6>{{trans('messages.app.no.properties')}}</h6>
            @else
                @foreach($properties as $property)
                    @include('shared.userProperty',['property'=>$property])
                @endforeach
            @endif
        </div>
        <div class="twelve columns">
            <a class="button" href="{{\App\Helper::getPathFor('user/create/property')}}">{{trans('messages.actions.add.property')}}</a>
        </div>
        <hr/>
        <div class="twelve columns">
            <h4>{{trans_choice('messages.words.operation', $actions->count())}}</h4>
        </div>
        <div class="twelve columns">
            @if($actions->count() == 0)
                <h6>{{trans('messages.app.no.actions')}}</h6>
            @else
                @foreach($actions as $action)
                    @include('shared.userAction',['action'=>$action])
                @endforeach
            @endif
        </div>
        <div class="twelve columns">
            <a class="button" href="{{\App\Helper::getPathFor('user/create/action')}}">{{trans('messages.actions.add.operation')}}</a>
        </div>
    </div>
@endsection
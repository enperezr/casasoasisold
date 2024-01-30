@section('styles')
    <link rel="stylesheet" href="{{asset('css/forms.css')}}">
@endsection
@section('scripts')
@endsection
@extends('layout.master')
@section('title', trans('messages.actions.publish'))
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('content')
<div class="row">
    <div class="large-6 columns">
        <form method="POST" action="/auth/login">
            {!! csrf_field() !!}
            <h3>{{trans('messages.words.entry')}}</h3>
            <p>{{trans('messages.app.registry.description')}}</p>
            <div>
                <label for="email">{{trans_choice('messages.words.mail', 1)}}</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
            </div>
            <div>
                <label for="password">{{trans('messages.words.password')}}:</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-actions">
                <button type="submit" class="button primary">{{trans('messages.words.login')}}</button>
            </div>
        </form>
    </div>
    <div class="large-6 columns">
        <h3>{{trans('messages.words.entry.code')}}</h3>
        <p>{{trans('messages.app.registry.code.description')}}</p>
        @if(session('message'))
            <h6 class="message text-center alert-message">
                {{session('message')}}
            </h6>
        @endif
        <form method="get" action="{{\App\Helper::getPathFor('user/temporal')}}" id="logon">
            <label for="code">{{trans('messages.words.code')}}:</label>
            <input type="text" id="code" name="c" value="{{ old('c') }}"/>
            <button type="submit" class="button primary">{{trans('messages.words.login')}}</button>
        </form>
    </div>
</div>
@endsection
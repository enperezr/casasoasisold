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
        <div class="large-offset-3 medium-offset-3 small-offset-1 large-6 medium-6 small-10 columns">
            <form method="POST" action="/auth/register">
                {!! csrf_field() !!}
                <h3> HabanaOasis {{trans('messages.words.registry')}}</h3>
                <p>{{trans('messages.app.registry.description')}}</p>
                <div class="input-control text full-size" data-role="input">
                    <label for="name">{{trans_choice('messages.words.name', 1)}}</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}">
                </div>
                <div>
                    <label for="email">{{trans_choice('messages.words.mail', 1)}}</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                </div>
                <div>
                    <label for="password">{{trans('messages.words.password')}}:</label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="password_confirmation">{{trans('messages.words.password.repeat')}}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation">

                </div>
                <div class="form-actions">
                    <button type="submit" class="button primary">{{trans('messages.words.register')}}</button>
                </div>
            </form>
        </div>
    </div>
 @endsection
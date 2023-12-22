@section('styles')
    <link rel="stylesheet" href="{{asset('css/forms.css')}}">
    <link rel="stylesheet" href="{{asset('css/guide.css')}}">
@endsection
@extends('layout.master')
@section('title', trans('messages.actions.publish.title'))
@section('description', trans('messages.app.publish.description'))
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('google')
    @include('portal.google-ads')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="large-6 columns large-push-3 form-container">
                <h3>
                    {{trans('messages.app.plan.payment.explain')}}
                </h3>
            </div>
        </div>
    </div>
@endsection
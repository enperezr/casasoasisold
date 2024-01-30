@section('styles')
    <link rel="stylesheet" href="{{asset('vendor/jStarbox/css/jstarbox.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lightbox/css/lightbox.css')}}">
@endsection
@section('scripts')

@endsection
@section('description', null !== $action->pivot->description ? $action->pivot->description : $property->getLabelName($action))
@section('keywords',$property->getKeyWordsForAction($action))
@extends('layout.master')
@section('title', trans('messages.words.reserve').' | '.$property->getLabelName($action))
@section('content')
    <div class="container" style="margin-bottom: 2em;">
        <div class="row text-center"><h5>{{trans('messages.actions.reservation.success')}}</h5></div>
        <div class="row text-center"><a class="button background-orange" href="{{\App\Helper::getPathFor('')}}">{{trans('messages.words.start')}}</a></div>
    </div>
@endsection
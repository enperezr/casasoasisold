@section('scripts')
    <script src="{{asset('js/welcome.js')}}"></script>
@endsection
@section('description', trans('messages.cuba.description'))
@section('keywords', trans('messages.cuba.keywords'))
@extends('layout.master')
@section('title', trans('messages.app.welcome'))
@section('content')
    <div class="container">
        <div class="row" id="photos">
            @include('cuba.flickr')
        </div>
    </div>
@endsection
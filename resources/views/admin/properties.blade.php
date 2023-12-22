@section('styles')
    <link rel="stylesheet" href="{{asset('vendor/dropzone/css/basic.css')}}">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('vendor/dropzone/js/dropzone.js')}}"></script>
    <script src="{{asset('js/translator.js')}}"></script>
    <script src="{{asset('js/propertyadmin.js')}}"></script>
@endsection
@extends('layout.admin')
@section('title', 'Admin Interface')
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('content')
    <div class="container full">
        <div class="row">
            <h1 class="float-left">Properties</h1>
        </div>
        <div class="row block-form collapse">
            <div class="large-4 columns">
                <label for="query">SEARCH</label>
                <input type="text" id="query" name="query" />
            </div>
            <div class="large-1 columns">
                <button class="button read-more search-button">SEARCH</button>
            </div>
            <div class="large-5 columns">
                <label for="filters">FILTERS</label>
                <div id="filters">
                    <ul class="filters_container inline-list list-unstyled"></ul>
                    <a class="edit trigger_filters"><i class="fa fa-edit"></i></a>
                </div>
            </div>
            <div class="large-2 columns">
                <label for="orderby">ORDER BY</label>
                <select name="orderby" id="orderby">
                    <option value="id">PROPERTY ID</option>
                    <option value="images">HAS IMAGES</option>
                    <option value="comments">HAS COMMENTS</option>
                    <option value="expiring">EXPIRING DATE</option>
                    <option value="published">PUBLISHED DATE</option>
                </select>
            </div>
        </div>
        <div class="row block-form collapse">
            <div class="large-12 columns">
                <table id="admin_properties">
                    <thead>
                        <tr>
                            <td class="text-center" width="100">META</td>
                            <td>user</td>
                            <td>contact</td>
                            <td width="120">action</td>
                            <td>localization</td>
                            <td width="130">days left</td>
                            <td>User Plan</td>
                            <td>published</td>
                            <td class="text-center">active</td>
                            <td>ended</td>
                            <td class="text-center">actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($properties as $property)
                            @include('admin.partials.trproperty',['property'=>$property,'user'=>$user, 'allowed_rols'=>$allowed_rols, 'currencies' => $currencies])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="reveal large" id="actions_container" data-reveal>
            <div class="container">
                <h4>Requesting your data now, please wait...</h4>
                <div class="row text-center">
                    <span id="loader"><i class="fa fa-spin fa-4x fa-yelp"></i></span>
                </div>
                <h6>Our loader is beautifull!!!!</h6>
            </div>
            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="reveal medium" id="loader_container" data-reveal>
            <div class="container text-center">
                <h5>It's AWE... wait for it... SOME!!! na, just searching now...</h5>
                <div class="row">
                    <span id="loader"><i class="fa fa-spin fa-4x fa-yelp"></i></span>
                </div>
            </div>
        </div>
        <div class="reveal medium" id="filters_container" data-reveal>
            <div class="controls">
                <label for="show">FILTERS</label>
                <select name="show" id="show">
                    <option value="GESTOR" id="GESTOR">GESTOR</option>
                    <option value="ACTIVE" id="ACTIVE">ACTIVE</option>
                    <option value="INACTIVE" id="INACTIVE">INACTIVE</option>
                    <option value="UNCONCLUDED" id="UNCONCLUDED">UNCONCLUDED</option>
                    <option value="CONCLUDED" id="CONCLUDED">CONCLUDED</option>
                    <option value="VENTA" id="VENTA">VENTA</option>
                    <option value="PERMUTA" id="PERMUTA">PERMUTA</option>
                </select>
                <button class="button" id="add_filter">ADD FILTER</button>
            </div>
            <div id="list_filters"></div>
            <div class="controls_group">
                <button class="button cancel" data-close aria-label="Close modal">CANCEL</button>
                <button class="button accept" id="accept_filters">ACCEPT</button>
            </div>
            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endsection

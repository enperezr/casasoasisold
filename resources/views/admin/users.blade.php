@section('styles')
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/datatables/css/dataTables.foundation.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/useradmin.js')}}"></script>
@endsection
@extends('layout.admin')
@section('title', 'Admin Interface')
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('content')
    <div class="container">
        <div class="row block-form">
            <div class="large-12">
                <div class="row">
                    <div class="large-4 columns">
                        <h1>Users</h1>
                    </div>
                    <div class="large-1 columns">
                        <a class="button" href="{{\App\Helper::getPathFor('admin/users/new')}}">Nuevo</a>
                    </div>
                </div>

                <table class="data data_local">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Rol</th>
                            <th>Created</th>
                            <th>Modified</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{explode(' ',$user->name)[0]}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->rol->name}}</td>
                                <td>{{\App\Helper::timeStamptToFormat($user->created_at, '%Y/%m/%d')}}</td>
                                <td>{{\App\Helper::timeStamptToFormat($user->updated_at, '%Y/%m/%d')}}</td>
                                <td>
                                    @if(Auth::user()->rol->name == 'admin' || (Auth::user()->rol->name == 'moderador' && $user->rol->name != 'admin'))
                                        <a class="command" href="{{\App\Helper::getPathFor('admin/users/toggle/'.$user->id)}}"><i class="fa @if($user->active)fa-flag @else fa-flag-o @endif"></i></a>
                                        <a class="command" href="{{\App\Helper::getPathFor('admin/users/edit/'.$user->id)}}"><i class="fa fa-edit"></i></a>
                                    @endif
                                </td>
                            </tr>
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
    </div>
@endsection
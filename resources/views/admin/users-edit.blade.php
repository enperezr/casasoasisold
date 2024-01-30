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
        <div class="row block-form-white">
            <div class="large-12">
                @if($user->id)
                    <h2>Editando Usuario [<span class="text-light">{{$user->name}} - {{$user->email}}</span>]</h2>
                @else
                    <h2>Nuevo Usuario</h2>
                @endif
                <form method="post" action="{{\App\Helper::getPathFor('admin/users/store/'.$user->id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$user->id}}" name="id">
                    <div class="row">
                        <div class="large-5 columns">
                            <label for="name">Nombre</label>
                            <input type="text" id="name" name="name" value="{{old('name', $user->name)}}" required>
                        </div>
                        <div class="large-5 columns">
                            <label for="email">E-Mail</label>
                            <input type="email" id="email" name="email" value="{{old('email', $user->email)}}" required>
                        </div>
                        <div class="large-2 columns">
                            <label for="rol">Rol</label>
                            <select name="rol" id="rol">
                                @foreach($roles as $role)
                                    @if(Auth::user()->rol->name == 'moderador' && $role->name != 'admin')
                                        <option value="{{$role->id}}" @if($user->rol_id == old('rol', $role->id))selected @endif>{{$role->name}}</option>
                                    @elseif(Auth::user()->rol->name == 'admin')
                                        <option value="{{$role->id}}" @if($user->rol_id == old('rol', $role->id))selected @endif>{{$role->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-5 columns">
                            <label for="phones">Teléfonos</label>
                            <input type="text" id="phones" name="phones" value="{{old('phones', ($user->gestor_contact ? $user->gestor_contact->phones : ''))}}">
                        </div>
                        <div class="large-1 columns">
                            <label for="gestor">Facilitador</label>
                            <select name="gestor" id="gestor">
                                <option value="0" @if($user->gestor == 0) selected @endif>NO</option>
                                <option value="1" @if($user->gestor == 1) selected @endif>Gestor</option>
                                <option value="2" @if($user->gestor == 2) selected @endif>Inmobiliaria</option>
                            </select>
                        </div>
                        <div class="large-3 columns">
                            <div class="image">
                                <img src="{{asset($user->avatar)}}">
                            </div>
                        </div>
                        <div class="large-3 columns">
                            <label for="avatar">Cambiar Avatar</label>
                            <input type="file" name="avatar" id="avatar">
                        </div>
                    </div>
                    <div id="password" style="border: 1px solid lightgray; padding: 10px; margin: 10px 0">
                        <div class="row">
                            <div class="large-12 columns">
                                <h4>Cambiar Contraseña</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-6 columns">
                                <label for="pass">Contraseña</label>
                                <input type="password" name="pass" id="pass">
                            </div>
                            <div class="large-6 columns">
                                <label for="repeat_pass">Repetir Contraseña</label>
                                <input type="password" name="repeat_pass" id="repeat_pass">
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <button type="submit" class="button">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
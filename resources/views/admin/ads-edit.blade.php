@extends('layout.admin')
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('title', 'Administrar Publicidad')
@section('content')
<div class="container full">
    <div class="row block-form collapse">
        <h1>@if($ad->id) Editando Publicidad {{$ad->id}} @else Nueva Publicidad @endif</h1>
        <div class="large-12 columns">
            <form method="post" action="{{\App\Helper::getPathFor('admin/ads/save')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" value="{{$ad->id}}" name="id" id="id">
            <div class="row">
                <fieldset>
                    <div class="large-6 columns">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" value="{{old('name', $ad->name)}}" required>
                    </div>
                    <div class="large-6 columns">
                        <label for="phone">Teléfono</label>
                        <input type="text" name="phone" id="name" value="{{old('phone', $ad->phone)}}" required>
                    </div>
                </fieldset>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <label for="fecha">Fecha Base</label>
                    <input type="date" name="fecha" id="fecha" value="{{old('fecha', $ad->fecha)}}" required>
                </div>
                <div class="large-3 columns">
                    <label for="time">Días</label>
                    <input type="number" id="time" name="time" value="{{old('time', $ad->time)}}" required>
                </div>
                <div class="large-3 columns">
                    <label for="priority">Prioridad</label>
                    <select name="priority" id="priority">
                        <option value="0" @if(old('priority', $ad->priority) == 0) selected @endif>0</option>
                        <option value="1" @if(old('priority', $ad->priority) == 1) selected @endif>1</option>
                        <option value="2" @if(old('priority', $ad->priority) == 2) selected @endif>2</option>
                        <option value="3" @if(old('priority', $ad->priority) == 3) selected @endif>3</option>
                    </select>
                </div>
                <div class="large-3 columns">
                    <label for="places">Lugares</label>
                    <select name="places[]" id="places" multiple required>
                        @foreach($pages as $page)
                        <option value="{{$page->id}}" @if(\App\Helper::contains(old('places', $ad->pages()->pluck('id')), $page->id)) selected @endif>{{$page->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label for="link">Enlace(opcional)</label>
                    <input type="text" name="link" id="link" value="{{old('link', $ad->link)}}">
                </div>
            </div>
            <div class="row">
                <div class="large-9 columns">
                    <img src="{{asset($ad->resource)}}" class="image_container">
                </div>
                <div class="large-3 columns">
                    <label for="resource">Recurso</label>
                    <input type="file" name="resource" id="resource">
                </div>
            </div>
            <div class="row">
                <div class="large-12 text-center">
                    <button class="button button-primary">Guardar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
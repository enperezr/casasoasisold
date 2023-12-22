@section('styles')
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection
@extends('layout.admin')
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('title', 'Administrar Publicidad')
@section('content')
    <div class="container full">
        <div class="row block-form collapse">
            <h1>Administrar Publicidad</h1>
            <a href="{{\App\Helper::getPathFor('admin/ads/new')}}" class="button button-primary float-right">Nuevo</a>
            <div class="large-12 columns">
                <table>
                    <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Lugares</th>
                        <th>Recurso</th>
                        <th>Enlace</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ads as $ad)
                    <tr>
                        <td>{{substr($ad->user->name, 0, 9).'('.($ad->user->rol->name[0]).')'}}</td>
                        <td>
                            <span>{{$ad->name}}</span><br><span>{{$ad->phone}}</span>
                        </td>
                        <td>
                            <?php $date = \Carbon\Carbon::createFromFormat('Y-m-d', $ad->fecha);?>
                            <span>{{$date->format('d/m/Y')}}</span><br> + <span>{{$ad->time}} Días</span><br>
                            <span>{!! $date->addDays($ad->time)->gt(\Carbon\Carbon::now()) ? '<span class="green">Quedan '.$date->diffInDays(\Carbon\Carbon::today()).' Días</span>' : '<span class="red">Terminado</span>' !!}</span>
                        </td>
                        <td>{{$ad->priority}}</td>
                        <td>{{$ad->places_string()}}</td>
                        <td><img src="{{asset($ad->resource)}}" width="200"></td>
                        <td>{{$ad->link}}</td>
                        <td>
                            <a href="{{\App\Helper::getPathFor('admin/ads/toggle/'.$ad->id)}}"><i class="fa {{$ad->active ? 'fa-flag' : 'fa-flag-o'}}"></i></a>
                            <a href="{{\App\Helper::getPathFor('admin/ads/edit/'.$ad->id)}}"><i class="fa fa-edit"></i></a>
                            <a href="{{\App\Helper::getPathFor('admin/ads/delete/'.$ad->id)}}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
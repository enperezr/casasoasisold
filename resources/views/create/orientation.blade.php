@section('styles')
<link rel="stylesheet" href="{{asset('css/publishinfo.css')}}">
@endsection
@extends('layout.master')
@section('title', trans('messages.actions.publish'))
@section('content')
    <div class="row background-gray presentation-block">
        <div class="large-12 columns row">
            <h2>Para publicar su casa en Habana Oasis</h2>
            <div class="medium-12 columns">
                <ul>
                    <li>Usted puede visitar nuestra sede ubicada en 31 esq 44 #4224, Playa.
                        Solo debe llevar fotos de su casa. Allí le tomaremos los datos.</li>
                    <li>Usted puede solicitar el servicio a domicilio. Vamos hasta su casa y
                        recogemos las fotos y los datos.</li>
                    <li>También puede solicitar el servicio de fotografía profesional. Envíamos un fotógrafo a su casa
                    y recogemos sus datos</li>
                </ul>
                <p>Para contáctarnos llame a los números: <strong>58421441</strong> y <strong>72060265</strong></p>
                <h5>Gracias por usar Habana Oasis</h5>
            </div>
        </div>
    </div>
@endsection
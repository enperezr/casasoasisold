<!doctype html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        <meta name="author" content="Inbitart">
        <link rel='shortcut icon' type='image/x-icon' href="{{asset('images/favicon.jpg')}}" />
        <title>{{trans('messages.app.shortname')}} | {{trans('messages.app.error.404')}}</title>
        <!-- TODO <link rel="alternate" type="application/rss+xml" title="{{trans('messages.app.shortname')}} RSS" href="??">-->
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" />
        <link rel="stylesheet" href="{{asset('vendor/foundation/css/foundation.css')}}" />
        <link rel="stylesheet" href="{{asset('css/errors.css')}}" />
    </head>
    <body>
        <div class="big-error">
            Mantenimiento
        </div>
        <div class="explain">
            <h4>Esta página está en mantenimiento</h4>
            <h6>Puedes continuar en la administración principal si tienes acceso <a href="{{\App\Helper::getPathFor('admin/dashboard')}}">Dashboard</a> o volver al <a href="{{\App\Helper::getPathFor('')}}">Inicio</a></h6>
        </div>
    </body>
</html>
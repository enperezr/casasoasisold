<!doctype html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="Inbitart">
    <link rel='shortcut icon' type='image/x-icon' href="{{asset('images/favicon.jpg')}}" />
    <title>{{trans('messages.app.shortname')}} | {{trans('messages.app.error.403')}}</title>
    <!-- TODO <link rel="alternate" type="application/rss+xml" title="{{trans('messages.app.shortname')}} RSS" href="??">-->
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/foundation/css/foundation.css')}}" />
    <link rel="stylesheet" href="{{asset('css/errors.css')}}" />
</head>
<body>
<div class="big-error er500">
    403
</div>
<div class="explain">
    <h4>{{trans('messages.app.error.403.explain')}}</h4>
    <h6>{!! trans('messages.app.error.404.links', ['buscar'=>'<a href="'.\App\Helper::getPathFor("busqueda").'"><strong>'.trans_choice('messages.actions.seek.property', 2).'</strong></a>',
             'inicio'=>'<a href="'.\App\Helper::getPathFor("").'"><strong>'.trans('messages.words.start').'</strong></a>']) !!}</h6>
</div>
</body>
</html>
<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@yield('description', trans('messages.app.description'))">
    <meta name="keywords" content="casas en venta en cuba, casa cubana, casa habana, inmobiliaria, portal inmobiliario, venta de casas en cuba, venta de casas en la habana, comprar casa en cuba, inmobiliaria, buscando casa, bienes raíces">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Inbitart">
    <title>@yield('title')</title>
    @yield('canonical')
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/foundation/css/foundation.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/common-dist.css')}}" />
    @yield('styles')   
</head>
<body>

    <div class="off-canvas-wrapper">
        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
            <div class="off-canvas-content" data-off-canvas-content>
                <div id="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/jquery-2.2.2-dist.js')}}"></script>
    <script src="{{asset('vendor/foundation/js/vendor/what-input.js')}}"></script>
    <script src="{{asset('vendor/foundation/js/vendor/foundation.min.js')}}"></script>   
    @yield('scripts')
     <script>
        $(document).foundation();
    </script>
</body>
</html>
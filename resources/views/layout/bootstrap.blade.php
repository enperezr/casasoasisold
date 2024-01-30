<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>

<!--<script async data-id="24667" src="https://cdn.widgetwhats.com/script.min.js"></script>-->

<!-- Start of Async Callbell Code -->
<script>
  window.callbellSettings = {
    token: "KBNjUDZBqWfqtwTbPVAVKpw9"
  };
</script>
<script>
  (function(){var w=window;var ic=w.callbell;if(typeof ic==="function"){ic('reattach_activator');ic('update',callbellSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Callbell=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://dash.callbell.eu/include/'+window.callbellSettings.token+'.js';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
</script>
<!-- End of Async Callbell Code -->

    <meta charset="UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@yield('description', trans('messages.app.description'))">
    <meta name="keywords" content="casas en venta en cuba, casa cubana, casa habana, inmobiliaria, portal inmobiliario, venta de casas en cuba, venta de casas en la habana, comprar casa en cuba, inmobiliaria, buscando casa, bienes raíces">
    @yield('opengraph')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Inbitart">
    <meta name="revisit-after" content="1 day">
    <meta name="google-site-verification" content="C6ftnsN_bVtwOL_mR704xfacqSzMVOEFNy4NZS-12sQ" />
    <link rel='shortcut icon' type='image/x-icon' href="{{asset('images/icon-app.png')}}" />
    <title>@yield('title')</title>
    @yield('canonical')
    <!-- TODO <link rel="alternate" type="application/rss+xml" title="{{trans('messages.app.shortname')}} RSS" href="??">-->
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-4.4.1-dist/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/bootstrap-common.css')}}" />
    @yield('styles')   
    
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-140751071-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-140751071-2');
</script>
    @yield('google')
</head>
<body>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v5.0&appId=548387299044805&autoLogAppEvents=1"></script>
<div class="navbar navbar-expand-lg navbar-dark bd-navbar pr-lg-5">
    <a class="navbar-brand" href="{{\App\Helper::getPathFor('')}}"><img src="{{asset("images/header/logo/logo-normal.jpg")}}" alt="Habana Oasis Logo" height="75"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{App\Helper::getPathFor('')}}">{{trans('messages.words.start')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{\App\Helper::getPathFor('listado-casas-venta-permuta-cuba')}}">{{trans_choice('messages.actions.seek.property', 1)}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{\App\Helper::getPathFor('nueva/propiedad')}}">{{trans('messages.actions.publish')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{\App\Helper::getPathFor('contactenos')}}">{{trans('messages.words.about')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href={{\App\Helper::getPathFor('descargas')}} tabindex="0">{{trans_choice('messages.words.download', 3)}}</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(\Illuminate\Support\Facades\App::getLocale()=='es')
                        ES
                    @else
                        EN
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{\App\Helper::getLangUrl('en')}}">EN - English</a>
                    <a class="dropdown-item" href="{{\App\Helper::getSpanishUrl()}}">ES - Español</a>
                </div>
            </li>
            @if(Auth::user())
            <li class="nav-item">
                <a href="{{\App\Helper::getPathFor('auth/logout')}}">{{Auth::user()->name}}(Salir)</a>
            </li>
            @endif
        </ul>
    </div>
</div>
<div class="container-fluid">
    <div id="main-content">
        @yield('content')
    </div>
</div>
<div class="container-fluid py-lg-4 px-lg-5" id="footer">
    <div class="row">
        <div class="col-md">
            <h5><strong>Habana Oasis</strong></h5>
            <ul>
                <li><a class="footer-link" href="">¿Cómo Funciona?</a></li>
                <li><a class="footer-link" href="">Valora Tu Casa</a></li>
                <li><a class="footer-link" href="{{\App\Helper::getPathFor('listado-casas-venta-permuta-cuba')}}">Nuestras Casas</a></li>
                <li><a class="footer-link" href="">Preguntas Frecuentes</a></li>
                <li><a class="btn btn-outline-light border rounded-pill mt-3"><strong>¿Buscas Casa?</strong></a></li>
            </ul>
        </div>
        <div class="col-md">
            <h5><strong>Sobre Nosotros</strong></h5>   
            <ul>
                <li><a class="footer-link" href="">Quiénes Somos</a></li>
                <li><a class="footer-link" href="">Trabaja en Habana Oasis</a></li>
                <li><a class="footer-link" href="{{\App\Helper::getPathFor('contactenos#contact-us')}}">{{trans('messages.app.contact-us')}}</a></li>
                <li><a class="footer-link" href="{{\App\Helper::getPathFor('terminos')}}">{{trans('messages.app.tos')}}</a></li>
                <li><a class="footer-link" href="{{\App\Helper::getPathFor('terminos#privacidad')}}">{{trans('messages.app.privacy')}}</a></li>
            </ul>
        </div>
        <div class="col-md">
            <h5 class="special"><strong>Llámanos Ahora</strong></h5>
            <ul>
                <li class="phone my-2"><i class="fa fa-phone"></i> <span>+53 58421441</span></li>
                <li>
                    <h6 class="mb-0"><strong>Lunes a Viernes</strong></h6>
                    <p>De 9:00 a 21:00</p>
                </li>
                <li>
                    <h6 class="mb-0"><strong>Sábados</strong></h6>
                    <p>De 9:00 a 14:00</p>
                </li>
            </ul>
        </div>
    </div>
    <hr/>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <span><img src="{{asset('images/header/logo/logo-mini-sq.jpg')}}" alt="Habana Oasis Logo"></span>
            <span>{{trans('messages.app.developed')}}</span> <a href="http://www.inbitart.com">INBITART</a>
        </div>
        <div id="social" class="">
            <ul class="list-group list-group-horizontal">
                <li class="px-2"><a href="http://www.facebook.com/habanaoasis"><i class="fa fa-2x fa-facebook-square"></i></a></li>
                <li><a href="http://youtu.be/mHKfV4tnW6A"><i class="fa fa-2x fa-youtube-square"></i></a></li>
            </ul>
        </div>
        <div>
            <a href="https://hostelsincuba.com/cuba-destinations/varadero">Varadero Beach </a> , <a href="https://hostelsincuba.com/">Hostels in Cuba </a>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery-2.2.2-dist.js')}}"></script>
<script src="{{asset('vendor/bootstrap-4.4.1-dist/js/bootstrap.bundle.min.js')}}"></script>   
@yield('scripts')
<div id="fb-root"></div>
<div class="fb-customerchat"
    attribution=setup_tool
    page_id="554430891381397"
    theme_color="#ff7e29">
</div>
</body>
</html>
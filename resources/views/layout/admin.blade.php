<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{asset('images/icon-app.png')}}" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/foundation/css/foundation.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/common-dist.css')}}" />
    @yield('styles')
</head>
<body>
    <div class="top-bar">
        <div class="top-bar-left">
            <ul class="dropdown menu" data-dropdown-menu>
                <li class="hide-for-large first has-offcanvas-left">
                    <a href="#" class="is-submenu-item is-dropdown-submenu-item" data-toggle="offCanvas-left"><i class="fa fa-search"></i></a>
                </li>
                <li>
                    <div id="title">
                        <div id="logo">
                            <a href="{{\App\Helper::getPathFor('')}}"><img src="{{asset("images/header/logo/logo-admin.jpg")}}" alt="Habana Oasis Logo"></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="top-bar-right">
            <ul class="dropdown menu" data-dropdown-menu>

                <li class="show-for-large">
                    <a href="{{\App\Helper::getPathFor('admin/properties')}}">Properties</a>
                </li>
                @if(Auth::user()->rol->name=='admin' || Auth::user()->rol->name=='moderador')
                    <li><a href="{{\App\Helper::getPathFor('admin/users')}}">Users</a></li>
                    <li><a href="{{\App\Helper::getPathFor('admin/comments')}}">Comments</a></li>
                    <li><a href="{{\App\Helper::getPathFor('admin/ads')}}">Advertisement</a></li>
                    <li><a href="{{\App\Helper::getPathFor('admin/finances')}}">Finances</a></li>
                @endif
                @if(Auth::user()->rol->name=='admin')
                    <li><a href="{{\App\Helper::getPathFor('admin/traces')}}">Traces</a></li>
                @endif
                <li>
                    <a href="{{\App\Helper::getPathFor('nueva/propiedad')}}" target="_blank">Publish</a>
                </li>
                <li>
                    <a href="{{App\Helper::getPathFor('')}}" target="_blank">Portal</a>
                </li>
                <li>
                    @if(Auth::user())
                        <a href="{{\App\Helper::getPathFor('auth/logout')}}">{{Auth::user()->name}}(Salir)</a>
                    @endif
                </li>
            </ul>
        </div>
</div>

<div class="clear"></div>
<div id="main-content">
    @yield('content')
</div>
<div class="footer"></div>
<script src="{{asset('js/jquery-2.2.2-dist.js')}}"></script>
<script src="{{asset('vendor/foundation/js/vendor/what-input.js')}}"></script>
<script src="{{asset('vendor/foundation/js/vendor/foundation.min.js')}}"></script>
@yield('scripts')
<script>
$(document).foundation();
</script>
</body>
</html>
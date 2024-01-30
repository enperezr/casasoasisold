<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@yield('description', trans('messages.app.description'))">
    <meta name="keywords"
        content="Casas Oasis">
    @yield('opengraph')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Expires" content="never">
    <meta name="distribution" content="Global">
    <meta name="Robots" content="INDEX,FOLLOW,ALL">
    <meta name="author" content="Inbitart">
    <meta name="revisit-after" content="1 day">
    <meta name="google-site-verification" content="C6ftnsN_bVtwOL_mR704xfacqSzMVOEFNy4NZS-12sQ" />
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('images/icon-app.png') }}" />
    <title>@yield('title')</title>
    @yield('canonical')
    <!-- TODO <link rel="alternate" type="application/rss+xml" title="{{ trans('messages.app.shortname') }} RSS" href="??">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/foundation/css/foundation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common-dist.css') }}" />
    @yield('styles')  

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140751071-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-140751071-2');
    </script>

</head>

<body>
    <div class="off-canvas-wrapper">
        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
            <div class="off-canvas position-right" id="offCanvas-right" data-off-canvas data-position="right">
                <button class="close-button" aria-label="Close menu" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="vertical menu">
                    <li>&nbsp;</li>
                    <li><a href="{{ App\Helper::getPathFor('') }}">{{ trans('messages.words.start') }}</a></li>
                    <li>
                        <ul class="menu vertical">
                            <li role="menuitem" class="is-submenu-item is-dropdown-submenu-item"><a
                                    href="{{ \App\Helper::getPathFor('venta/viviendas') }}">{{ trans('messages.actions.seek.buy') }}</a>
                            </li>
                            <li role="menuitem" class="is-submenu-item is-dropdown-submenu-item"><a
                                href="{{ \App\Helper::getPathFor('permuta/viviendas') }}">{{ trans('messages.actions.seek.exchange') }}</a>
                            </li>
                            <li role="menuitem" class="is-submenu-item is-dropdown-submenu-item super-highlight"><a
                                    href="{{ \App\Helper::getPathFor('nueva/propiedad') }}">{{ trans('messages.actions.publish') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <div class="languages">
                            <a href="{{ \App\Helper::getLangUrl('es') }}"
                                class="secondary hollow button @if (App::getLocale() == 'es') selected @endif">ES</a>
                            <a href="{{ \App\Helper::getLangUrl('en') }}"
                                class="secondary hollow button @if (App::getLocale() == 'en') selected @endif">EN</a>
                        </div>
                    </li>
                    <li>
                        @if (Auth::user())
                            <a href="{{ \App\Helper::getPathFor('auth/logout') }}">{{ Auth::user()->name }}(Salir)</a>
                        @endif
                    </li>
                </ul>
            </div>
            <div class="off-canvas position-left" id="offCanvas-left" data-off-canvas data-position="left">
                <button class="close-button" aria-label="Close menu" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
                @yield('offcanvas-left')
            </div>
            <div class="off-canvas-content" data-off-canvas-content>
                <div class="top-bar">
                    <div class="top-bar-left">
                        <ul class="dropdown menu" data-dropdown-menu>
                            <li class="hide-for-large first has-offcanvas-left">
                                <a href="#" class="is-submenu-item is-dropdown-submenu-item"
                                    data-toggle="offCanvas-left"><i class="fa fa-search"></i></a>
                            </li>
                            <li>
                                <div id="title">
                                    <div id="logo">
                                        <a href="{{ \App\Helper::getPathFor('') }}"><img
                                                src="{{ asset('images/header/logo/logo-normal-new.png') }}"
                                                alt="Habana Oasis Logo" width="259" height="90"></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="top-bar-right">
                        <ul class="dropdown menu" data-dropdown-menu>
                            <li class="show-for-large">
                                <a href="{{ App\Helper::getPathFor('') }}">{{ trans('messages.words.start') }}</a>
                            </li>
                            <li class="show-for-large">
                                <a
                                    href="{{ \App\Helper::getPathFor('venta/viviendas') }}">{{ trans('messages.actions.seek.buy') }}</a>
                            </li>
                            <li class="show-for-large">
                                <a
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas') }}">{{ trans('messages.actions.seek.exchange') }}</a>
                            </li>
                            <li class="show-for-large">
                                <a tabindex="4">
                                    @if (\Illuminate\Support\Facades\App::getLocale() == 'es')
                                        ES
                                    @else
                                        EN
                                    @endif
                                </a>
                                <ul class="menu vertical">
                                    <li role="menuitem" class="is-submenu-item is-dropdown-submenu-item"><a
                                            href="{{ \App\Helper::getLangUrl('en') }}">EN - English</a></li>
                                    <li role="menuitem" class="is-submenu-item is-dropdown-submenu-item"><a
                                            href="{{ \App\Helper::getLangUrl('es') }}">ES - Español</a></li>
                                </ul>
                            </li>
                            <li class="show-for-large super-highlight">
                                <a href="{{ \App\Helper::getPathFor('nueva/propiedad') }}">
                                    {{ trans('messages.actions.publish') }}
                                </a>
                            </li>
                            <li>
                                @if (Auth::user())
                                    <a
                                        href="{{ \App\Helper::getPathFor('auth/logout') }}">{{ Auth::user()->name }}(Salir)</a>
                                @endif
                            </li>
                            <li class="hide-for-large">
                                <a class="is-submenu-item is-dropdown-submenu-item" data-toggle="offCanvas-right"><i
                                        class="fa fa-dedent"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="clear"></div>
                <div id="main-content">
                    @yield('content')
                </div>

                <div class="footer">
                    <div class="row text-center">
                        <ul class="inline-list footer-menu">
                            <li><a class="footer-link"
                                    href="{{ \App\Helper::getPathFor('') }}">{{ trans('messages.words.start') }}</a>
                            </li>
                            <li><a class="footer-link"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas') }}">{{ trans('messages.actions.seek.buy') }}</a>
                            </li>
                            <li><a class="footer-link"
                                href="{{ \App\Helper::getPathFor('permuta/viviendas') }}">{{ trans('messages.actions.seek.exchange') }}</a>
                            </li>
                            <li><a class="footer-link"
                                    href="{{ \App\Helper::getPathFor('contactenos#contact-us') }}">{{ trans('messages.app.contact-us') }}</a>
                            </li>
                            <li>
                                <a class="footer-link" href="{{ \App\Helper::getPathFor('contactenos') }}">{{ trans('messages.words.about') }}</a>
                            </li>                           
                            <li><a class="footer-link"
                                    href="{{ \App\Helper::getPathFor('terminos') }}">{{ trans('messages.app.tos') }}</a>
                            </li>
                            <li><a class="footer-link"
                                    href="{{ \App\Helper::getPathFor('terminos#privacidad') }}">{{ trans('messages.app.privacy') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="row text-center">
                        <div id="social">
                            <ul class="list-unstyled">
                                <li><a href="http://www.facebook.com/habanaoasis" target="_blank"><i
                                            class="fa fa-2x fa-facebook-square"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UCuFnSYusBZftVHvQUFk_OUg" target="_blank"><i class="fa fa-2x fa-youtube-square"></i></a></li>
                                <li><a href="https://www.linkedin.com/company/habanaoasis/" target="_blank"><i class="fa fa-2x fa-linkedin-square"></i></a>
                                </li>
                                <li><a href="https://twitter.com/habanaoasis/" target="_blank"><i class="fa fa-2x fa-twitter-square"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div style="margin-left: 20px">
                            <span><img src="{{ asset('images/header/logo/logo-mini.png') }}" alt="Habana Oasis Logo"
                                    height="60" width="171"></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messenger Plugin de chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin de chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "554430891381397");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v15.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/es_ES/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

    <script src="{{ asset('js/jquery-2.2.2-dist.js') }}"></script>
    <script src="{{ asset('vendor/foundation/js/vendor/what-input.js') }}"></script>
    <script src="{{ asset('vendor/foundation/js/vendor/foundation.min.js') }}"></script>
    @yield('scripts')
    <script>
        $(document).foundation();
    </script>
    @if (Request::url() != url('nueva/propiedad') && Request::url() != url('en/nueva/propiedad'))
        <div id="search" class="floating-control hide-for-medium">
            <a href="{{ \App\Helper::getPathFor('nueva/propiedad') }}"
                class="button">{{ trans('messages.actions.publish') }}</a>
        </div>
    @endif
</body>

</html>

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/contactus.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/mediaelementjs/mediaelementplayer.min.css') }}" />
@endsection
@section('scripts')
    <script src="{{ asset('js/tiles.js') }}"></script>
    <script src="{{ asset('vendor/mediaelementjs/mediaelement-and-player.min.js') }}"></script>
    <script>
        $('#mediaplayer').mediaelementplayer({});
    </script>
@endsection
@section('keywords', trans('messages.app.keywords'))
@extends('layout.master')
@section('title', trans('messages.app.us.and.contact'))
@section('description', trans('messages.app.contactus.description'))
@section('google')
    @include('portal.google-ads')
@endsection
@section('content')
    <div class="container">
        @include('portal.ads', ['place' => '6'])
        <div class="row">
            <div class="large-12 columns">
                <div class="block">
                    <div id="faqs">
                        <h1 class="title">¿Qué es Habana Oasis?</h1>
                        <p class="description">Habana Oasis es el futuro de las inmobiliarias en Cuba, es el proyecto de
                            programación más novedoso y práctico para vender, comprar y permutar una casa en soporte
                            digital. Fue creado por el grupo de desarrollo INBITART. Cuenta con una Web y aplicaciones para
                            computadoras y equipos móviles. Diseñado para alcanzar y conectar el mayor número de personas en
                            muy corto tiempo. Ofrece una asistencia segura, fácil de instalar, como actualizar.</p>
                        <p class="description">Queremos que disfrutes tu búsqueda o tu promoción con la mayor comodidad,
                            utilizando nuestros productos gratis y servicios de alta calidad con precios módicos. El
                            beneficio, es inmediato, al ingresar tus datos en nuestra web pasan automáticamente a las
                            aplicaciones, y por ende, todos te verán.</p>
                        <video id="mediaplayer" src="{{ asset('images/spot-480.mp4') }}" height="270"
                            style="max-width:100%;" preload="none" type="video/mp4"
                            poster="{{ asset('images/video.jpg') }}"></video>
                        <hr />
                        <h3 class="title">¿Qué te ofertamos diferente de una inmobiliaria convencional?</h3>
                        <ol>
                            <li><strong>No hay que pagar ningún porciento ni antes ni después</strong>, solo la publicidad.
                            </li>
                            <li><strong>No somos intermediarios</strong>, accedemos a que miles de usuarios te conozcan y te
                                llamen directamente, decide a quien vender.</li>
                            <li>Puedes preguntarle al sistema usando filtros de búsqueda muy rápidos que encuentran tus
                                necesidades al detalle.</li>
                            <li>Con una simple llamada telefónica, iremos a tu casa para unirte a la familia.</li>
                            <li>Brindamos servicio de fotografía profesional o puedes enviarnos las tuyas.</li>
                            <li>Se crean previo encargo, visitas virtuales para que el cliente revise la casa desde el
                                programa y así no moleste al propietario.</li>
                            <li>Variadas vías de actualización: “El Paquete”, Talleres, zonas WiFi, un amigo.</li>
                        </ol>                        
                    </div>
                    <hr />

                    <hr />
                    <div id="contact">
                        <h3 class="title">¿Dónde encontrarnos o contactarnos?</h3>

                        <p class="contact-data">Cel:+53 58421441</p>
                        <p class="contact-data">Correos: info@habanaoasis.com / habanaoasis@nauta.cu</p>
                    </div>
                    <hr />
                    <div id="reflexion">
                        <h5>Reflexión Cibernética</h5>
                        <blockquote class="text-justify italic">
                            Todos deseamos avanzar en nuestra mecánica vida pero el 85% de nosotros seguimos haciendo
                            las viejas rutinas oxidadas, nos dormimos en nuestra zona de confort, caminamos por los mismos
                            senderos trillados,usamos los programas ya establecidos para encontrar algo o publicitarnos
                            sin darle espacio a las nuevas tendencias, el hábito nos ciega, dejando pasar oportunidades
                            únicas donde podemos evolucionar. El riesgo calculado de escalar una cima nueva e interesante,
                            no es solo para aventureros alpinistas, te invitamos a subir y vencer tu montaña con nosotros.
                            Bienvenido, usuario.
                        </blockquote>
                        <p class="text-right">INBITART</p>
                        <p>PD: Si ya tienes los programas y los estás usando, te avisamos que si detectas algún defecto o
                            falla notifícalo a nuestros teléfonos o taller. Gracias adelantadas, los técnicos.</p>
                    </div>
                </div>
                <div class="block contact-us" id="contact-us">
                    <div id="form-contact">
                        <h3 class="title">Contactános ahora mismo!</h3>
                        @if (session('message'))
                            <div class="alert alert-success">
                                Gracias por contactarnos. Atenderemos su correo lo más rápido posible.
                            </div>
                        @else
                            <p class="descrption">A pesar de que hemos trabajado muy fuerte en este servicio, sabemos de
                                nuestra falibilidad. Si encuentras algún error, mal funcionamiento en cualquiera de nuestras
                                apps o la web; si tienes alguna duda concerniente a nuestros servicios, o solo porque lo
                                deseas, puedes enviarnos un mensaje por aquí ahora mismo. Recuerda dejar clara la forma de
                                contactarte. Estamos para servirte.</p>
                            <form method="post" action="/contactenos/send">
                                {{ csrf_field() }}
                                <label for="mail">Correo Electrónico</label>
                                <input id="mail" type="text" name="mail">
                                <label for="text">Texto</label>
                                <textarea id="text" name="text" rows="4"></textarea>
                                <button type="submit" class="button">Envíar</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

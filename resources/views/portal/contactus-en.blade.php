@section('styles')
    <link rel="stylesheet" href="{{ asset('css/contactus.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/mediaelementjs/mediaelementplayer.min.css') }}" />
@endsection
@section('scripts')
    <script src="{{ asset('js/tiles.js') }}"></script>
    <script src="{{ asset('vendor/mediaelementjs/mediaelement-and-player.min.js') }}"></script>
    <script>
        $('#mediaplayer').mediaelementplayer({
            pluginPath: "/path/to/shims/",
            poster: "/images/video.jpg",
            success: function(mediaElement, originalNode) {
                // do things
            }
        });
    </script>
@endsection
@section('description', trans('messages.app.description'))
@section('keywords', trans('messages.app.keywords'))
@extends('layout.master')
@section('title', trans('messages.app.us.and.contact'))
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
                        <h1 class="title">What is Habana Oasis?</h1>
                        <p class="description">Habana Oasis is the future of cuban real state, it's a newfangled programming
                            proyect to sell, buy and interchange houses in the digital world. Was created by the development
                            group INBITART. The proyect is composed by a web site and apps for desktop computers and movile
                            devices. Designed to reach and connect a lot of people in the lowest time. Offers easy and safe
                            installation.</p>
                        <p class="description">We want you to enjoy your search or your sell announce with confort, using
                            our free products and high quality services at lower prices. Inmediate benefit, your data is
                            ready for all our apps inmediatly you add it in the web next time they update, everybody will
                            see you.</p>
                        <h3 class="title">What make us different from normal real state agencies?</h3>
                        <ol>
                            <li><strong>No need to pay any percent of your sell or buy</strong>, just advertising.</li>
                            <li><strong>We are not in the middle</strong>, Tons of users will meet you and probably callyou
                                directly, you choose who wins the sell.</li>
                            <li>Search the system with fast filters to find exactly what you need</li>
                            <li>With a simple phone call, we will go to you.</li>
                            <li>Professional photography service from us, or you send the pictures.</li>
                            <li>By request, we create virtual tours from your house so your client check the house in the
                                app and callyou less.</li>
                            <li>Many ways of updating: “El Paquete”, Cells workshops, WIFI zones, a friend.</li>
                        </ol>
                    </div>
                    <hr />
                    <hr />
                    <div id="contact">
                        <h3 class="title">Where are we?</h3>

                        <p class="contact-data">Cel:+53 58421441</p>
                        <p class="contact-data">Mails: info@habanaoasis.com / habanaoasis@nauta.cu</p>
                    </div>
                    <hr />
                    <div id="reflexion">
                        <h5>Cibernetics Reflection</h5>
                        <blockquote class="text-justify italic">
                            We all wish to go forward in our mechanistic life nevertheless 85% of us continue repeating
                            the old rusty routines, numbs in our confort zone, we walk the same trites ways, using the
                            same known programs to find something or advertise ourselves without giving space to the new
                            trends
                            The habit blind us, ignoring unique oportunities, perfect to evolve, as they present to us.
                            The calculated risk of climbing a new and interesting hill, is not just for adventurers,
                            We invite you to climb and defeat your mountain with us.
                            Welcome, user.
                        </blockquote>
                        <p class="text-right">G.D. INBITART</p>
                        <p>PD: If you are using our apps, we askyou that if you detect some error or fail notify us
                            to our phones or base. Thanks in advance. The developers.</p>
                    </div>
                </div>
                <div class="block contact-us" id="contact-us">
                    <div id="form-contact">
                        <h3 class="title">Contact right now!</h3>
                        @if (session('message'))
                            <div class="alert alert-success">
                                Thanks for contact. We'll reach you in the shortest time posible.
                            </div>
                        @else
                            <p class="descrption">Despite we have work very hard in this service, We know that mistakes
                                certainly happen. If you find some error, Bad behaviour in any of our apps or the web;
                                If you have some doubt about our services, or just because you want, Send a message using
                                this form right now. Remember to leave us a way to reach you. We are here to serve.</p>
                            <form method="post" action="/contactenos/send">
                                {{ csrf_field() }}
                                <label for="mail">E-mail</label>
                                <input id="mail" type="text" name="mail">
                                <label for="text">Text</label>
                                <textarea id="text" name="text" rows="4"></textarea>
                                <button type="submit" class="button">Send</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

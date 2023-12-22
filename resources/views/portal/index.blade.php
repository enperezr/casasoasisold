@section('opengraph')
    <meta property="og:title" content="{{ trans('messages.app.welcome') }}">
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:image" content="{{ asset('images/video.jpg') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="{{ trans('messages.app.description') }}" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ trans('messages.app.welcome') }}">
    <meta name="twitter:description" content="{{ trans('messages.app.description') }}">
    <meta name="twitter:image" content="{{ asset('images/video.jpg') }}">
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/tiles.css') }}" />
    <link rel="alternate" type="application/atom+xml" title="News" href="/feed">
@endsection
@section('scripts')
    <script src="{{ asset('js/helpers.js') }}"></script>
    <!--<script src="{{ asset('js/index-dist.js') }}"></script>-->
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/tiles.js') }}"></script>

    <script data-schema="Organization" type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "RealEstateAgent",
            "name": "Casas Oasis",
            "image": "https://casasoasis.com/images/video.jpg",
            "logo": "https://casasoasis.com/images/video.jpg",
            "description": "Permuta y Venta de Casas sin comisiones.",
            "@id": "https://casasoasis.com/",
            "url": "https://casasoasis.com/",
            "telephone": "+5358421441",
            "aggregateRating": {
                "@type": "AggregateRating",
                "bestRating": 5,
                "worstRating": 1,
                "ratingValue": 4.7,
                "ratingCount": "4097"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+5358421441",
                "contactType": "customer service"
            },
            "openingHoursSpecification": [{
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday"
                ],
                "opens": "09:00",
                "closes": "17:00"
            }, {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                    "Saturday",
                    "Sunday"
                ],
                "opens": "10:00",
                "closes": "17:00"
            }],
            "sameAs": [
                "https://www.facebook.com/habanaoasis/",
                "https://www.instagram.com/habanaoasisdotcom/",
                "https://www.linkedin.com/company/habanaoasis/",
                "https://twitter.com/habanaoasis/",
                "https://www.youtube.com/channel/UCuFnSYusBZftVHvQUFk_OUg"
            ]
        }
    </script>

@endsection

@section('description', trans('messages.app.description'))
@section('keywords', trans('messages.app.keywords'))
@section('title', trans('messages.app.welcome'))
@section('canonical')
    <link rel="canonical" href="{{ Request::url() }}">
@endsection
@extends('layout.master')
@section('content')
    @include('portal.ads', ['place' => '1'])
    <div class="row background-gray presentation-block">
        <div class="large-12 columns row">
            <h1>{{ trans('messages.app.searcher.top') }}</h1>
            <br>
            <h2>{{ trans('messages.app.searcher.pitch') }}</h2>
            <div class="medium-3 columns">
                <label for="action">{{ trans_choice('messages.words.operation', 1) }}</label>
                <select name="action" id="action">
                    <option value="venta">{{ trans_choice('messages.words.sale', 2) }}</option>
                    <option value="permuta">{{ trans_choice('messages.words.permuta', 2) }}</option>
                </select>
            </div>
            <div class="medium-3 columns">
                <label for="province">{{ trans_choice('messages.words.province', 1) }}</label>
                <select name="province" id="province">
                    <option value="0">- {{ trans_choice('messages.words.all', 15) }} -</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->slugged }}">{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="medium-6 columns">
                <div class="row toggle">
                    <div class="medium-4 columns venta">
                        <label for="price-min">{{ trans('messages.app.price.min') }}</label>
                        <input type="text" id="price-min">
                    </div>
                    <div class="medium-4 columns venta">
                        <label for="price-max">{{ trans('messages.app.price.max') }}</label>
                        <input type="text" id="price-max">
                    </div>
                    <div class="medium-4 columns venta">
                        <label for="currency">{{ trans('messages.app.currency') }}</label>
                        <select name="currency" id="currency">
                            <option value="0">- {{ trans_choice('messages.words.all.f', 15) }} -</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}">{{ $currency->slugged }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="small-12 columns permuta">
                        <div class="small-12 columns" id="condition_s">
                            <label for="condition">{{ trans_choice('messages.words.permuta', 1) }}</label>
                            <select name="condition" id="condition">
                                <option value="0">{{ trans_choice('messages.words.all.f', 2) }}</option>
                                <option value="1x1">1x1</option>
                                <option value="multiple">{{ trans('messages.app.multiple.permuta') }}</option>
                                <option value="user">{{ trans('messages.words.specific') }}</option>
                            </select>
                        </div>
                        <div class="small-8 columns" id="specific">
                            <div class="small-6 columns">
                                <label for="give">{{ trans('messages.words.offer.present') }}</label>
                                <input type="text" name="give" value="1" id="give">
                            </div>
                            <div class="small-6 columns">
                                <label for="want">{{ trans('messages.words.wish.present') }}</label>
                                <input type="text" name="want" value="2" id="want">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a id="search-now" class="button read-more">{{ trans('messages.actions.seek.now') }}</a>
        </div>
    </div>

    @if ($last_sales->count() > 0)
        <div class="row properties-block background-gray" id="last-sales">
            <h2>{{ trans_choice('messages.words.sale', 2) }}</h2>
            <hr class="mini text-center">
            <h2>{{ trans('messages.app.last.properties.venta') }}</h2>
            <p>{{ trans('messages.app.last.properties.sale.description') }}</p>
            <ul class="inline-list properties-list">
                @foreach ($last_sales as $property)
                    @foreach ($property->actions as $action)
                        @if ($action->action_id == 1)
                            <li>
                                @include('shared.property', [
                                    'property' => $property,
                                    'action' => $action,
                                ])
                            </li>
                        @endif
                    @endforeach
                @endforeach
            </ul>
            <a href="{{ \App\Helper::getPathFor('venta/viviendas') }}"
                class="button radius bordered gray read-more">{{ trans('messages.actions.seek.more') }}</a>
        </div>

        @if ($highlighted_sales && $highlighted_sales->count() > 0)
            <div class="row properties-block background-gray" id="highlighted-sales">
                <h2>{{ trans('messages.app.last.properties.specials') }}</h2>
                <p>{{ trans('messages.app.last.properties.specials.description') }}</p>
                <ul class="inline-list properties-list">
                    @foreach ($highlighted_sales as $property)
                        @foreach ($property->actions as $action)
                            <li>
                                @include('shared.newproperty', [
                                    'property' => $property,
                                    'action' => $action,
                                ])
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
        @endif
    @endif
    @if ($last_exchanges->count() > 0)
        <div class="row properties-block" id="last-exchanges">
            <div class="header">
                <h2>{{ trans_choice('messages.words.permuta', 2) }}</h2>
                <hr class="mini text-center">
                <h2 class="sub">{{ trans('messages.app.last.properties.permuta') }}</h2>
                <p>{{ trans('messages.app.last.properties.exchanges.description') }}</p>
            </div>
            <ul class="inline-list properties-list">
                @foreach ($last_exchanges as $property)
                    @foreach ($property->actions as $action)
                        @if ($action->action_id == 2)
                            <li>
                                @include('shared.property', [
                                    'property' => $property,
                                    'action' => $action,
                                ])
                            </li>
                        @endif
                    @endforeach
                @endforeach
            </ul>
            <a href="{{ \App\Helper::getPathFor('permuta/viviendas') }}"
                class="button bordered gray read-more">{{ trans('messages.actions.seek.more') }}</a>
        </div>
    @endif

    @include('shared.interlinktabs', [
        '$provinces' => $provinces,
        '$types' => $types,
    ])
@endsection

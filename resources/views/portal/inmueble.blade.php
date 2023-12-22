@section('opengraph')
    <meta property="og:title" content="{{ $property->getLabelName($action) . ' : ' . $property->id }}" />
    @if ($property->getMainPicture())
        <meta property="og:image"
            content="{{ asset('images/properties/' . $property->id . '/' . $property->getMainPicture()->localization) }}" />
        <meta name="twitter:image"
            content="{{ asset('images/properties/' . $property->id . '/' . $property->getMainPicture()->localization) }}">
    @else
        <meta property="og:image" content="{{ asset('images/properties/default/avatar_casa.png') }}" />
        <meta name="twitter:image" content="{{ asset('images/properties/default/avatar_casa.png') }}">
    @endif
    <meta property="og:type" content="website" />
    <meta property="og:description"
        content="{{ trans('messages.property.generated.description', [
            'action' => trans('messages.db.action.' . $action->action->slugged),
            'type' => trans_choice('messages.db.property.' . $property->typeProperty->slugged, 1),
            'locality' => $property->locality->name != 'unspecified' ? $property->locality->name . ', ' : '',
            'municipio' => $property->municipio->name,
            'province' => $property->province->name,
            'rooms' => $property->rooms,
            'baths' => $property->baths,
            'price' => $action->price ? ', ' . trans_choice('messages.words.price', 1) . ': $' . $action->price : '',
        ]) }}" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $property->getLabelName($action) . ' : ' . $property->id }}">
    <meta name="twitter:description"
        content="{{ trans('messages.property.generated.description', [
            'action' => trans('messages.db.action.' . $action->action->slugged),
            'type' => trans_choice('messages.db.property.' . $property->typeProperty->slugged, 1),
            'locality' => $property->locality->name != 'unspecified' ? $property->locality->name . ', ' : '',
            'municipio' => $property->municipio->name,
            'province' => $property->province->name,
            'rooms' => $property->rooms,
            'baths' => $property->baths,
            'price' => $action->price ? ', ' . trans_choice('messages.words.price', 1) . ': $' . $action->price : '',
        ]) }}">
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/jStarbox/css/jstarbox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
    <link rel='stylesheet' href="{{ asset('vendor/unitegallery/css/unite-gallery.css') }}" type='text/css' />
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inmueble.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tiles.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('vendor/jStarbox/jstarbox.js') }}"></script>
    <script src="{{ asset('vendor/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/unitegallery/js/unitegallery.min.js') }}"></script>
    <script src="{{ asset('vendor/unitegallery/themes/tiles/ug-theme-tiles.js') }}"></script>
    <script src="{{ asset('js/validator.js') }}"></script>
    <script src="{{ asset('js/helpers.js') }}"></script>
    <script src="{{ asset('js/property.js') }}"></script>
    <script src="{{ asset('js/tiles.js') }}"></script>
    @include('shared.schema', ['property' => $property, 'action' => $action])
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=5ca7b9b2fb6af900122ed564&product=inline-share-buttons">
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function onSubmit(token) {
            document.getElementById("review-form").submit();
        }
    </script>
@endsection
@section('description',
    trans('messages.property.generated.description', [
    'action' => trans('messages.db.action.' . $action->action->slugged),
    'type' => trans_choice('messages.db.property.' . $property->typeProperty->slugged, 1),
    'locality' => $property->locality->name != 'unspecified' ? $property->locality->name . ', ' : '',
    'municipio' => $property->municipio->name,
    'province' => $property->province->name,
    'rooms' => $property->rooms,
    'baths' => $property->baths,
    'price' => $action->price ? ', ' . trans_choice('messages.words.price', 1) . ': $' . $action->price : '',
    ]))
@section('keywords', $property->getKeyWordsForAction($action->action))
@extends('layout.master')
@section('title', $property->getLabelName($action) . ' : ' . $property->id)
@section('canonical')
    <link rel="canonical" href="{{ Request::url() }}">
@endsection
<?php if (!$action->contact && $action->gestor_user) {
    $action->contact = $action->gestor_user->gestor_contact;
} ?>
@section('content')
    <article>
        <div class="full-w
    th presentation">
            <div class="row" style="margin-bottom: 10px">

            </div>

            <div class="row">
                <div class="large-12 columns">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li class="entry">
                                <span class="badget_seek">{{ trans('messages.actions.seek.more') }} <i
                                        class="fa fa-play"></i></span>
                            </li>
                            <?php $urls = $property->getBreadcrumbsLinks($action); ?>
                            @foreach ($urls as $u)
                                <li><a href="{{ $u[0] }}">{{ $u[1] }}</a></li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <div class="large-12 columns">
                    <div class="large-8 columns main">
                        <div class="row general-data">
                            <div class="avatar-container float-left">
                                <div class="avatar">
                                    @if ($property->getMainPicture())
                                        <figure>
                                            <img src="{{ asset('images/properties/' . $property->id . '/30/' . $property->getMainPicture()->localization) }}"
                                                alt="{{ $property->getLabelName() }}" />
                                        </figure>
                                    @else
                                        <img src="{{ asset('images/properties/default/50/avatar_casa.png') }}"
                                            alt="{{ $property->getLabelName() }}" />
                                    @endif
                                </div>
                                <h5 class="text-center bold" style="color: #0098E8">REF. #{{ $property->id }}</h5>
                            </div>
                            <h1 class="with-subheader inmueble">
                                {{ $property->name ? $property->name : $property->getLabelName($action) }}</h1>
                            <div class="data-container float-left">
                                <div class="main-data">
                                    @if ($property->rooms > 0)
                                        <div class="rooms">
                                            <div>
                                                {{ $property->rooms - intval($property->rooms) == 0 ? $property->rooms : floor($property->rooms) . '&frac12;' }}
                                                <i>
                                                    <object data="{{ asset('images/icons/cama-negra.svg') }}" height="21"
                                                        width="25" type="image/png">
                                                        <img src="{{ asset('images/icons/cama-negra.png') }}"
                                                            alt="bed image icon">
                                                    </object>
                                                </i>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($property->baths > 0)
                                        <div class="baths">
                                            <div>
                                                {{ $property->baths }}
                                                <i>
                                                    <object data="{{ asset('images/icons/bano-negro.svg') }}" height="21"
                                                        width="26" type="image/png">
                                                        <img src="{{ asset('images/icons/bano-negro.png') }}"
                                                            alt="bath image icon">
                                                    </object>
                                                </i>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($property->surface > 0)
                                        <span class="size"><i class="fa fa-expand"></i>
                                            {{ $property->surface }} m<sup>2</sup>
                                        </span>
                                    @endif
                                </div>

                                <div class="evaluation">
                                    @if ($property->has_virtual)
                                        <a href="http://virtuales.habanaoasis.com/{{ $property->id }}" target="_blank">
                                            <div class="clearfix inverse">
                                                <i class="fa fa-video-camera"> Virtual</i>
                                            </div>
                                        </a>
                                    @endif
                                    <a href="#images">
                                        <div class="clearfix">
                                            {{ $property->images->count() }} <i class="fa fa-image"></i><i
                                                class="fa fa-arrow-down float-right"></i>
                                        </div>
                                    </a>
                                    <!--
                                            <a href="#comments">
                                                <div class="clearfix">
                                                    {{ $property->reviews->count() }} <i class="fa fa-comments"></i><i class="fa fa-arrow-down float-right"></i>
                                                </div>
                                            </a>
                                            -->
                                </div>
                            </div>
                        </div>
                        <div class="sharethis-inline-share-buttons"></div>
                    </div>
                    <div class="large-4 columns side">
                        <div class="reserve side-block show-for-large">
                            <div
                                class="reserve-header{{ $action->concluded ? ' concluded' : '' }} {{ $action->contact->_gestor ? 'gestor' : '' }}">
                                <div class="price float-left">
                                    @if ($action->concluded)
                                        <h5 class="value">
                                            <span
                                                class="concluded">{{ $action->price ? '$' . \App\Helper::formatPrice($action->price) : $action->condition }}</span>
                                            <span
                                                class="state">({{ $action->action->id == 1 ? trans('messages.words.sold') : trans('messages.words.permutada') }})</span>
                                        </h5>
                                    @else
                                        <h5 class="value">
                                            @if ($action->price)
                                                {{ '$' . \App\Helper::formatPrice($action->price) }}
                                                @if ($action->currency)
                                                    {{ trans($action->currency->slugged) }}
                                                @endif
                                            @else
                                                {{ $action->condition }}
                                            @endif
                                        </h5>
                                    @endif
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="reserve-body">
                                <div class="row column">
                                    <div class="large-12 columns">
                                    </div>
                                </div>
                            </div>
                            @if ($action->contact->_gestor)
                                <div class="contact gestor">
                                    <div class="contact-details">
                                        <div class="name">Presentada Por
                                            <span>{{ $action->contact->names }}</span>
                                            <span class="facilitador">({{ trans('messages.words.gestor') }})</span>
                                        </div>
                                        <div class="card">
                                            <div class="avatar">
                                                <img src="{{ asset($action->contact->_gestor->avatar) }}">
                                            </div>
                                            <div class="data-contact">
                                                @if ($action->contact->phones)
                                                    <p><i class="fa fa-phone-square"></i>{{ $action->contact->phones }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="contact">
                                    <div class="contact-details">
                                        @if (!$action->concluded)
                                            @if (!$property->address)
                                                <div class="name">
                                                    <strong>{{ $action->contact->names }}</strong>
                                                </div>
                                            @else
                                                <div class="name">
                                                    <strong>{{ $action->contact->names }}</strong>
                                                </div>
                                                <div class="address"><i
                                                        class="fa fa-home"></i>{{ $property->address }}</div>
                                            @endif
                                            @if ($action->contact->phones)
                                                <p class="phone">
                                                    <strong><i
                                                            class="fa fa-mobile-phone"></i>{{ $action->contact->phones }}</strong>
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="full-width property-data">
            <div class="row">
                <div class="large-12 columns">
                    <div class="large-8 columns main no-padding-left">
                        @if (!$action->concluded)
                            @if ($action->contact->_gestor)
                                <div class="contact-data hide-for-large gestor row">
                                    <div class="medium-3 columns">
                                        <h5><strong>Presentada por</strong><span class="facilitador">
                                                (Facilitador)</span>
                                        </h5>
                                    </div>
                                    <div class="medium-9 columns">
                                        <div class="row">
                                            <div class="small-4 medium-2 columns">
                                                <div class="avatar"><img
                                                        src="{{ asset($action->contact->_gestor->avatar) }}"></div>
                                            </div>
                                            <div class="small-8 medium-10 no-padding-left columns">
                                                <p>{{ $action->contact->names }}</p>
                                                <p><i class="fa fa-phone-square"></i>{{ $action->contact->phones }}</p>
                                                @if (preg_match_all(Config::get('app.mail_regex'), $action->contact->mail))
                                                    <p><i
                                                            class="fa fa-envelope-square"></i>{{ trans('messages.app.send.mail.owner') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="contact-data hide-for-large">
                                    <div class="medium-2 columns no-padding-left">
                                        <h5><strong>{{ trans('messages.app.contact.data') }}</strong></h5>
                                    </div>
                                    <div class="medium-10 columns">
                                        <div class="medium-4 columns">
                                            <p class="phone"><strong>{{ $action->contact->names }}</strong></p>
                                        </div>
                                        <div class="medium-4 columns">
                                            <p class="phone"><strong><i
                                                        class="fa fa-mobile-phone"></i>{{ $action->contact->phones }}</strong>
                                            </p>

                                        </div>
                                        <div class="medium-4 columns">
                                            <div class="address"><i
                                                    class="fa fa-home"></i>{{ $property->address }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="clear hide-for-large">
                                <hr />
                            </div>
                        @endif
                        @if ($property->description or $action->description)
                            @if ($property->description)
                                <div class="user-description text-justify">
                                    <h5 class="section-name"><strong>{{ trans('messages.app.inmueble.info') }}</strong>
                                    </h5>
                                    <p></p>
                                    <p>
                                        {!! $property->description !!}
                                    </p>
                                </div>
                            @endif
                            @if ($action->description)
                                <div class="user-description text-justify">
                                    <h5 class="section-name"><strong>{{ trans('messages.app.announce.info') }}</strong>
                                    </h5>
                                    <p></p>
                                    <p>
                                        {!! $action->description !!}
                                    </p>
                                </div>
                            @endif
                        @else
                            <h5 class="section-name">{{ trans('messages.app.announce.info') }}</h5>
                            <p></p>
                            <p>
                                {{ trans('messages.app.no.description') }}
                            </p>
                        @endif

                        <div class="place-description block-inmuebles">
                            <div class="medium-3 columns no-padding-left">
                                {{ trans('messages.app.place') }}
                            </div>
                            <div class="medium-9 columns">
                                <div class="medium-12 columns">
                                    <div class="small-6 columns">
                                        <ul class="list-unstyled margin-sm-0">
                                            <li>{{ trans_choice('messages.words.bath', 2) }}:
                                                <strong>{{ $property->baths }}</strong>
                                            </li>
                                            <li>{{ trans_choice('messages.words.room', 2) }}:
                                                <strong>{{ $property->rooms - intval($property->rooms) == 0 ? $property->rooms : floor($property->rooms) . '&frac12;' }}</strong>
                                            </li>
                                            <li>{{ trans('messages.words.highness') }}:<strong>{{ $property->highness ? $property->highness : ' P. Baja' }}</strong>
                                            </li>
                                            <li>{{ trans('messages.app.property.type') }}:
                                                <strong>{{ trans_choice('messages.db.property.' . $property->typeProperty->slugged, 1) }}</strong>
                                            </li>
                                            <li><span
                                                    class="show-for-large">{{ trans('messages.app.kitchen.distribution') }}:</span>
                                                <strong>{{ trans('messages.db.kitchen.' . $property->typeKitchen->slugged) }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="small-6 columns">
                                        <ul class="list-unstyled margin-sm-0">
                                            <li>{{ trans('messages.app.type.construction') }}:
                                                <strong>{{ trans('messages.db.construction.' . $property->typeConstruction->slugged) }}</strong>
                                            </li>
                                            <li>{{ trans('messages.app.state.inmueble') }}:
                                                <strong>{{ trans('messages.db.property.state.' . $property->stateConstruction->slugged) }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        @if ($property->commodities->count() > 0)
                            <div class="extras block-inmuebles">
                                <div class="medium-3 columns no-padding-left">
                                    {{ trans_choice('messages.words.extra', 2) }}
                                </div>
                                <div class="medium-9 columns">
                                    <div class="medium-12 columns">
                                        <div class="small-6 columns">
                                            <ul class="list-unstyled margin-sm-0">
                                                @for ($i = 0; $i < $property->commodities->count() / 2; $i++)
                                                    <li><strong>{{ trans('messages.db.extra.' . $property->commodities->get($i)->slugged) }}</strong>
                                                    </li>
                                                @endfor
                                            </ul>
                                        </div>
                                        <div class="small-6 columns">
                                            <ul class="list-unstyled margin-sm-0">
                                                @for ($i = round($property->commodities->count() / 2); $i < $property->commodities->count(); $i++)
                                                    <li><strong>{{ trans('messages.db.extra.' . $property->commodities->get(intval($i))->slugged) }}</strong>
                                                    </li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        @endif
                        <div class="price block-inmuebles">
                            <div class="medium-3 columns no-padding-left">
                                @if ($action->action->id == 1)
                                    {{ trans_choice('messages.words.price', 1) }}
                                @else
                                    {{ trans_choice('messages.words.permuta', 1) }}
                                @endif
                            </div>
                            <div class="medium-9 columns">
                                <div class="medium-12 columns">
                                    <div class="medium-push-6 medium-6 columns">
                                        <ul class="list-unstyled margin-sm-0">
                                            @if ($action->action->id == 1)
                                                <li>
                                                    <span class="{{ $action->concluded ? 'concluded' : '' }}">
                                                        @if ($action->price)
                                                            <strong>${{ \App\Helper::formatPrice($action->price) }}</strong>
                                                            @if ($action->currency)
                                                                <strong>{{ trans($action->currency->slugged) }}</strong>
                                                            @endif
                                                        @else
                                                            <strong>{{ trans('messages.app.contact.owner') }}</strong>
                                                        @endif
                                                    </span>
                                                    @if ($action->concluded)
                                                        <span class="state">
                                                            <span
                                                                class="state">({{ trans('messages.words.sold') }})</span>
                                                        </span>
                                                    @endif
                                                </li>
                                            @else
                                                <li>
                                                    <span class="{{ $action->concluded ? 'concluded' : '' }}">
                                                        <strong>{{ $action->condition }}</strong>
                                                    </span>
                                                    @if ($action->concluded)
                                                        <span class="state">
                                                            <span
                                                                class="state">({{ trans('messages.words.permutada') }})</span>
                                                        </span>
                                                    @endif
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="address block-inmuebles show-for-large">
                            <div class="small-3 columns no-padding-left">
                                {{ trans('messages.words.address') }}
                            </div>
                            <div class="small-9 columns">
                                <div class="small-12 columns">
                                    <div class="small-12 columns">
                                        {{ $property->address }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="fp block-inmuebles">
                            <div class="small-3 columns no-padding-left">
                                {{ trans('messages.app.publishing.date') }}
                            </div>
                            <div class="small-9 columns">
                                <div class="small-12 columns">
                                    <div class="small-6 columns"></div>
                                    <div class="small-6 columns">
                                        <div style="margin-left: 1.25rem">
                                            <strong>{{ strftime(trans('formats.date'), strtotime($property->updated_at)) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="images block-inmuebles" id="images">
                            <div id="gallery" style="display:none;">
                                <?php $loop = 0; ?>
                                @foreach ($property->images as $image)
                                    <a href="http://unitegallery.net">
                                        <img alt="{{ $property->getLabelName() . ' ' . ($loop > 0 ? $loop : '') }}"
                                            src="{{ asset('images/properties/' . $property->id . '/30/' . $image->localization) }}"
                                            data-image="{{ asset('images/properties/' . $property->id . '/' . $image->localization) }}"
                                            data-description="{{ $image->description }}" style="display:none">
                                    </a>
                                    <?php $loop++; ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 10px">
        </div>
        <?php $similar = $property->getSimilars($action->action, 4); ?>
        @if ($similar->count() > 0)
            <div class="full-width suggestions">
                <h3 class="text-center">{{ trans('messages.app.also.interesting') }}</h3>
                <div class="row properties-block">
                    <ul class="inline-list properties-list">
                        @foreach ($property->getSimilars($action->action, 4) as $similar)
                            <li>@include('shared.property', [
                                'property' => $similar,
                                'action' => $similar->getThisAction($action->action)[0],
                            ])</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </article>
@endsection()

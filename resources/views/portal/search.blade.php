@extends('layout.master')
@section('title', $title)
@section('canonical')
    <?php
      $url = Request::url();
    ?>
    <link rel="canonical" href="{{ $url }}" />
@endsection
@section('description', trans('messages.app.search.description', ['title' => $title]))
@section('keywords', trans('messages.app.search.keywords'))
@section('opengraph')
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:url" content="{{ $url }}" />
    <meta property="og:image" content="{{ asset('images/video.jpg') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:description"
        content="{{ trans('messages.app.search.description',[
            'title' => $title
            ]) }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description"
        content="{{ trans('messages.app.search.description', [
            'title' => $title
            ]) }}">
@endsection
@section('styles')
    <link rel='stylesheet' href='{{ asset('vendor/unitegallery/css/unite-gallery.css') }}' type='text/css' />
    <link rel="stylesheet" href="{{ asset('css/search2.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('vendor/unitegallery/js/unitegallery.min.js') }}"></script>
    <script src="{{ asset('vendor/unitegallery/themes/tiles/ug-theme-tiles.js') }}"></script>
    <script src="{{ asset('js/helpers.js') }}"></script>
    <script src="{{ asset('js/search.js') }}">
    </script>
@endsection
@section('offcanvas-left')
    <div style="height: 50px"></div>
    <div id="side-filters-off"></div>
@endsection
@section('google')
    @include('portal.google-ads')
@endsection
@section('content')
    @include('portal.ads', ['place' => '2'])
    <div id="results">
        <div class="row">
            <div class="large-3 columns show-for-large" id="side-filters">
                <div class="filters">
                    <ul class="tabs" data-tabs id="filters-tabs-off">
                        <li class="tabs-title is-active"><a href="#top-filters-off"
                                aria-selected="true">{{ trans_choice('messages.words.filter', 2) }}</a></li>
                        <li class="tabs-title"><a href="#other-filters-off"> +
                                {{ trans_choice('messages.words.filter', 2) }}</a></li>
                    </ul>
                    <div class="tabs-content" data-tabs-content="filters-tabs-off">
                        <div class="tabs-panel is-active" id="top-filters-off">
                            <div class="form-search">
                                <div class="row">
                                    <input type="checkbox" checked name="gestor" id="gestor" value="1"><label
                                        for="gestor">{{ trans('messages.app.search.gestor_including') }}</label>
                                    <label for="action">{{ trans_choice('messages.words.operation', 1) }}:</label>
                                    <select name="action" id="action" class="u-full-width">
                                        @foreach ($actions as $action)
                                            @if ($action->id == 1 || $action->id == 2)
                                                <option value="{{ $action->id }}"
                                                    {{ $taction->id == $action->id ? 'selected=selected' : '' }}
                                                    id="{{ $action->id }}">
                                                    {{ trans('messages.db.action.' . $action->slugged . '.p') }}({{ $propertiesPerAction->has($action->id) ? $propertiesPerAction[$action->id][0]['total'] : 0 }})
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row hidden show-for-comprar show-for-rentar">
                                    <label for="price">{{ trans_choice('messages.words.price', 1) }}:</label>
                                    <div class="columns small-6 no-padding">
                                        <label for="price-min">{{ trans('messages.app.filter.from') }}</label>
                                        <input id="price-min" name="surface-min" class="u-full-width" type="text"
                                            value="{{ $price_min or '0' }}" />
                                    </div>
                                    <div class="columns small-6 no-padding-right">
                                        <label for="price-max">{{ trans('messages.app.filter.to') }}</label>
                                        <input id="price-max" name="surface-max" class="u-full-width" type="text"
                                            value="{{ $price_max or '999999999' }}" />
                                    </div>
                                </div>

                                <div class="row hidden show-for-comprar show-for-rentar">
                                    <label for="currency">{{ trans('messages.app.currency') }}</label>
                                    <select name="currency" id="currency">
                                        <option value="0">- {{ trans_choice('messages.words.all.f', 15) }} -</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}"
                                                {{ $tcurrency == $currency->id ? 'selected=selected' : '' }}>
                                                {{ $currency->slugged }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row hidden show-for-permutar">
                                    <label for="condition">{{ trans_choice('messages.words.permuta', 1) }}</label>
                                    <select id="condition" class="form-select full-width" name="condition">
                                        <option value="0" @if ($condition == 0) selected="selected" @endif>
                                            {{ trans_choice('messages.words.all', 2) }}</option>
                                        <option value="1x1" @if ($condition == '1x1') selected="selected" @endif>1x1
                                        </option>
                                        <option value="multiple"
                                            @if ($condition == 'multiple') selected="selected" @endif>
                                            {{ trans('messages.app.multiple.permuta') }}</option>
                                        <option value="user" @if ($condition != '1x1' && $condition != 'multiple' && $condition != 0) selected="selected" @endif>
                                            {{ trans('messages.words.specific') }}</option>
                                    </select>
                                    <div>
                                        <label for="give">{{ trans('messages.words.offer.present') }}</label>
                                        <input id="give" name="give" class="u-full-width" type="text"
                                            value="{{ $give }}" />
                                    </div>
                                    <div>
                                        <label for="want">{{ trans('messages.words.wish.present') }}</label>
                                        <input type="text" name="want" value="{{ $want }}" id="want">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="province"
                                        class="control-label">{{ trans_choice('messages.words.province', 15) }}:</label>
                                    <select id="province" class="form-select full-width" name="province">
                                        <option value="0">- {{ trans_choice('messages.words.all', 15) }} -</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}" data-url="{{ $province->slugged }}"
                                                data-id="{{ $province->id }}"
                                                @if (isset($tprovince) && $tprovince->id == $province->id) selected="selected" @endif>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="municipio"
                                        class="control-label">{{ trans_choice('messages.words.municipio', 15) }}:</label>
                                    <select id="municipio" class="form-select full-width" name="municipio">
                                        <option value="0">- {{ trans_choice('messages.words.all', 15) }} -</option>
                                        @if ($tprovince)
                                            @foreach ($municipios as $municipio)
                                                <option value="{{ $municipio->id }}"
                                                    data-url="{{ $municipio->slugged }}" class="dynamic"
                                                    @if (isset($tmunicipio) && $tmunicipio->id == $municipio->id) selected="selected" @endif>
                                                    {{ $municipio->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="locality"
                                        class="control-label">{{ trans_choice('messages.words.locality', 15) }}:</label>
                                    <select id="locality" class="form-select full-width" name="locality">
                                        <option value="0">- {{ trans_choice('messages.words.all', 15) }} -</option>
                                        @if ($tmunicipio)
                                            @foreach ($localities as $locality)
                                                <option value="{{ $locality->id }}"
                                                    data-url="{{ $locality->slugged }}" class="dynamic"
                                                    @if (isset($tlocality) && $tlocality->id == $locality->id) selected="selected" @endif>
                                                    {{ $locality->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="columns small-6 no-padding">
                                        <label for="rooms">{{ trans_choice('messages.words.room', 2) }}</label>
                                        <select id="rooms" name="rooms" class="u-full-width">
                                            <option value="1" selected="selected">1</option>
                                            <option value="2" {{ $rooms == 2 ? 'selected=selected' : '' }}>2</option>
                                            <option value="3" {{ $rooms == 3 ? 'selected=selected' : '' }}>3</option>
                                            <option value="4" {{ $rooms == 4 ? 'selected=selected' : '' }}>4</option>
                                        </select>
                                    </div>
                                    <div class="columns small-6 no-padding-right">
                                        <label for="baths">{{ trans_choice('messages.words.bath', 2) }}</label>
                                        <select id="baths" name="baths" class="u-full-width">
                                            <option value="1" selected="selected">1</option>
                                            <option value="2" {{ $baths == 2 ? 'selected=selected' : '' }}>2</option>
                                            <option value="3" {{ $baths == 3 ? 'selected=selected' : '' }}>3</option>
                                            <option value="4" {{ $baths == 4 ? 'selected=selected' : '' }}>4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="type">{{ trans('messages.app.property.type') }}:</label>
                                    <select name="type" id="type" class="u-full-width">
                                        <option value="0" id="0">{{ trans_choice('messages.words.all', 2) }}</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}"
                                                {{ $type->id == $ttype ? 'selected=selected' : '' }}
                                                id="{{ $type->id }}">
                                                {{ trans_choice('messages.db.property.' . $type->slugged, 1) }}</option>
                                        @endforeach
                                    </select>
                                    <label for="state">{{ trans('messages.app.state.inmueble') }}:</label>
                                    <select name="state" id="state" class="u-full-width">
                                        <option value="0">{{ trans_choice('messages.words.all', 2) }}</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}"
                                                {{ $state->id == $tstate ? 'selected=selected' : '' }}
                                                id="{{ $state->id }}">
                                                {{ trans('messages.db.property.state.' . $state->slugged) }}</option>
                                        @endforeach
                                    </select>
                                    <label for="type_construction">{{ trans('messages.app.type.construction') }}:</label>
                                    <select name="type_construction" id="type_construction" class="u-full-width">
                                        <option value="0">{{ trans_choice('messages.words.all', 2) }}</option>
                                        @foreach ($typesConstruction as $tconstruction)
                                            @if ($tconstruction->slugged != 'propiedad')
                                                <option value="{{ $tconstruction->id }}"
                                                    {{ $tconstruction->id == $ttypeConstruction ? 'selected=selected' : '' }}
                                                    id="{{ $tconstruction->id }}">
                                                    {{ trans('messages.db.construction.type.' . $tconstruction->slugged) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label>{{ trans_choice('messages.words.surface', 1) }}</label>
                                    <div class="columns small-6 no-padding">
                                        <label for="surface-min">{{ trans('messages.app.filter.from') }}</label>
                                        <select id="surface-min" name="surface-min" class="u-full-width">
                                            <option value="0" selected="selected">0</option>
                                            <option value="50">50m</option>
                                            <option value="100">100m</option>
                                            <option value="200">200m</option>
                                        </select>
                                    </div>
                                    <div class="columns small-6 no-padding-right">
                                        <label for="surface-max">{{ trans('messages.app.filter.to') }}</label>
                                        <select id="surface-max" name="surface-max" class="u-full-width">
                                            <option value="999999999" selected="selected">infinito</option>
                                            <option value="50">50m</option>
                                            <option value="100">100m</option>
                                            <option value="300">300m</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tabs-panel" id="other-filters-off">
                            <div class="form-search">
                                <div class="row" id="extras">
                                    <label for="extras">{{ trans_choice('messages.words.extra', 2) }}</label>
                                    <ul class="option-group">
                                        <?php $c = collect($textras); ?>
                                        @foreach ($extras as $extra)
                                            <?php $checked = $c->contains($extra->id); ?>
                                            <li>
                                                <i class="fa @if ($checked) fa-check-square @else fa-square-o @endif o-extra"
                                                    data-id="{{ $extra->id }}"></i>
                                                <input type="checkbox" name="extra[]" class="extras"
                                                    value="{{ $extra->id }}"
                                                    @if ($checked) checked="checked" @endif
                                                    id="e-{{ $extra->id }}">
                                                <span
                                                    @if ($checked) class="selected" @endif>{{ trans('messages.db.extra.' . $extra->slugged) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="button read-more" id="search">{{ trans('messages.actions.seek') }}</button>
                    <button class="button clean-search"
                        id="cleaner">{{ trans('messages.actions.seek.clean.all') }}</button>
                </div>

            </div>
            <div class="large-9 columns" id="resultsList">
                <div class="row">
                    <h1>{{ $h1 }}</h1>
                </div>
                <div class="row" id="loader" style="display: none;">
                    <div id="progress">
                        <div id="new">
                            <span><i class="fa fa-refresh fa-spin"></i>{{ trans('messages.words.loading') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="presentation-controls">
                        <span id="count" class="float-left">
                            Total: <span class="bold">{{ $search->total() }}</span>
                        </span>
                        <div id="orders" class="float-right">
                            <div class="control">
                                <select id="order" name="order" class="form-select minimal">
                                    <option value="recent" {!! $order == 'recent' ? 'selected=selected' : '' !!}>{{ trans('messages.words.newest') }}
                                    </option>
                                    <option value="oldest" {!! $order == 'oldest' ? 'selected=selected' : '' !!}>{{ trans('messages.words.oldest') }}
                                    </option>
                                    <option value="expensive" {!! $order == 'expensive' ? 'selected=selected' : '' !!} class="ventas">
                                        {{ trans('messages.words.most.adj', ['adj' => trans('messages.words.expensive')]) }}
                                    </option>
                                    <option value="cheap" {!! $order == 'cheap' ? 'selected=selected' : '' !!} class="ventas">
                                        {{ trans('messages.words.sheapest') }}</option>
                                    <option value="small" {!! $order == 'small' ? 'selected=selected' : '' !!}>{{ trans('messages.words.smallest') }}
                                    </option>
                                    <option value="big" {!! $order == 'big' ? 'selected=selected' : '' !!}>{{ trans('messages.words.biggest') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="row" style="margin-bottom: 10px">

                </div>
                <?php $duplicates = collect([]); ?>
                @foreach ($search as $result)
                    @if (!$duplicates->contains($result->id))
                        <?php $pactions = $result->getThisAction($result->ac); ?>
                        @foreach ($pactions as $paction)
                            @include('shared.property-long', [
                                'property' => $result,
                                'action' => $paction,
                                'h3'=>$h3
                            ])
                        @endforeach
                    @endif
                @endforeach
                <div class="clear"></div>
                <div class="row" style="margin-bottom: 10px">

                </div>
                <div class="row" id="pagination">
                    <?php echo $search->render(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>

    @if (!$tprovince)
        @include('shared.interlinktabs', [
            '$tab_active' => $tab_active,
            '$subtab_active' => $subtab_active,
            '$types' => $types,
            '$ttype' => $ttype,
            '$actions' => $actions,
        ])
    @else

      @include('shared.searchrelated',[
          'tprovince'=> $tprovince,
          'tmunicipio'=>$tmunicipio,
          'tlocality'=>$tlocality,
          'municipios' => $municipios,
          'localities' => $localities,
          'placeRela'=>$placeRela,
          'types'=> $types,
          'ttype'=>$ttype,
          'ttypeslugged' => ($ttype == 0) ? "viviendas": $types->filter(function ($item) use ($ttype) {
            return $item->id == $ttype;
            })->first()->sluggedplural,
          '$taction'=>$taction
      ])
    @endif



@endsection

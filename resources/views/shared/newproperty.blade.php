<article class="property">
    <div class="hover-menu">
        <div class="location">

        </div>
        <div class="more-details">
            @if ($action->price)
                <span class="price">
                    {{ $action->price ? '$' . \App\Helper::formatPrice($action->price) : $action->permuta }}

                    <span class="medida">
                        @if ($action->price && $action->currency)
                            {{ $action->price ? trans($action->currency->slugged) : '' }}
                        @endif
                    </span>
                </span>
            @endif
            @if ($action->condition)
                <span class="condition">{{ $action->condition }}</span>
            @endif
            <div class="bath-rooms">
                <span>{{ $property->rooms }}
                    <i>
                        <object data="{{ asset('images/icons/cama-white.svg') }}" height="21" width="25"
                            type="image/png">
                            <img src="{{ asset('images/icons/cama-white.png') }}" alt="bed image icon" height="21"
                                width="25">
                        </object>
                    </i>
                </span>
                @if ($property->baths)
                    <span>{{ $property->baths }}
                        <i>
                            <object data="{{ asset('images/icons/bano-white.svg') }}" height="21" width="26"
                                type="image/png">
                                <img src="{{ asset('images/icons/bano-negro.png') }}" alt="bath image icon" height="21"
                                    width="26">
                            </object>
                        </i>
                    </span>
                @endif
            </div>
        </div>
        <div class="read-more">
            <a href="{{ $property->getUrl($action) }}">
                <i class="fa fa-search"></i>
                {{ trans_choice('messages.words.details', 2) }}
            </a>
        </div>
    </div>
    <div class="property-container">
        @if ($action->concluded)
            <div class="badget">
                @if ($action->action->id == 1)
                    <span><img src="{{ asset('images/' . trans('messages.words.sold') . '.png') }}" height="168"
                            width="81"> </span>
                @else
                    <span><img src="{{ asset('images/' . trans('messages.words.permutada') . '.png') }}" height="168"
                            width="81"></span>
                @endif
            </div>
        @endif
        <div class="property-image">{{-- TODO  detectar tamanno de imagen --}}
            <a href="{{ $property->getUrl($action) }}#main-content">
                @if ($property->getMainPicture())
                    <figure>
                        <img src="{{ asset('images/properties/' . $property->id . '/50/' . $property->getMainPicture()->localization) }}"
                            alt="{{ $property->getLabelName() }}" />
                    </figure>
                @else
                    <img src="{{ asset('images/properties/default/50/avatar_casa.png') }}"
                        alt="House with no pictures" />
                @endif
            </a>
        </div>
        <div class="bottom-data">
            <span class="province pull-left">
                {{ $property->province->name }}
            </span>
            <span class="price pull-right">
                {{ $action->price ? '$' . \App\Helper::formatPrice($action->price) : $action->condition }}
                @if ($action->price && $action->currency)
                    {{ trans($action->currency->slugged) }}
                @endif
            </span>
            <div class="u-cf"></div>
        </div>
    </div>
</article>

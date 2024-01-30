<article class="row property-long @if ($property->gestor) gestor @endif" data-property="{{ $property->id }}">

    <div class="picture display-inline">
        @if ($property->getMainPicture())
            <figure id="figuresearch">
                <img src="{{ asset('images/properties/' . $property->id . '/70/' . $property->getMainPicture()->localization) }}"
                    alt="{{ $property->getLabelName() }}" />
            </figure>
            <a href="#" class="pictures-trigger"><img
                    src="{{ $property->has_virtual? asset('images/icons/recorridolista.png'): asset('images/icons/picture-trigger.png') }}"></a>
        @else
            <img src="{{ asset('images/properties/default/70/avatar_casa.png') }}"
                alt="{{ $property->getLabelName() }}" />
        @endif
    </div>

    <div class="details display-inline">
        <?php $label_name = $property->name ? $property->name : $property->getLabelName($action); ?>
        <a href="{{ $property->getUrl($action) }}">
        <h3>
            <div class="price display-block action">
                @if (($action->price === 0 || $action->price === null) && !$action->condition)
                    @if (!$action->concluded)
                        <span {{ $action->concluded ? 'class=concluded' : '' }}>{{ trans('messages.app.contact.owner') }}</span>
                    @endif
                @else
                    <span {{ $action->concluded ? 'class=concluded' : '' }}>
                        @if ($action->price)
                            {{ '$' . \App\Helper::formatPrice($action->price) }}
                            @if ($action->currency)
                                {{ trans($action->currency->slugged) }}
                            @endif
                        @else
                            {{ $action->condition }}
                        @endif
                        <span>{{ !$action->price === null ? trans_choice('messages.words.option', 1) : '' }}</span>
                    </span>
                @endif
                @if ($action->concluded)
                    <span><i class="fa fa-info-circle" style="color: red; cursor: pointer;"
                            title="{{ trans('messages.app.action.concluded') }}"></i></span>
                @endif
            </div>
            <span>{{ trans_choice('messages.db.property.'.$property->typeProperty->slugged, 1) .' '. trans('messages.words.in')  .' '.$property->address}}</span>
        </h3>
        <div class="entry-features">
            @if ($property->rooms > 0)
                <span class="rooms">
                    <i>
                        <object data="{{ asset('images/icons/cama-negra.svg') }}" height="16" width="22"
                            type="image/png">
                            <img src="{{ asset('images/icons/cama-negra.png') }}" alt="bed image icon">
                        </object>
                    </i>
                    {{ $property->rooms }}
                    {{ $property->rooms > 1? trans_choice('messages.words.room.lower', 2): trans_choice('messages.words.room.lower', 1) }}
                </span>
            @endif
            @if ($property->baths > 0)
                <span class="baths">
                    <i style="padding-top: .5em">
                        <object data="{{ asset('images/icons/bano-negro.svg') }}" height="16" width="22"
                            type="image/png">
                            <img src="{{ asset('images/icons/bano-negro.png') }}" alt="bath image icon">
                        </object>
                    </i>
                    {{ $property->baths }}
                    {{ $property->baths > 1? trans_choice('messages.words.bath.lower', 2): trans_choice('messages.words.bath.lower', 1) }}
                </span>
            @endif
            @if ($property->surface > 0)
                <span class="size">
                    <i class="fa fa-expand"></i>
                    {{ $property->surface }} m<sup>2</sup>
                </span>
            @endif
        </div>
       <span class="cut-text show-for-large show-for-medium">
            {!! $property->description !!}
       </span>
    </a>
        <div class="entry-price show-for-small-only {{ strlen($label_name) > 20 ? 'no-padding' : '' }}">
            <div class="read-more">
                <?php $phone = explode(',', $action->contact->phones); ?>
               <a href="{{'tel:'. $phone[0] }}"><i class="fa fa-phone"></i> <span>{{ $phone[0] }}</span></a>
            </div>
        </div>
    </div>
    <div class="price-data display-inline show-for-medium">
        @if (!$action->concluded)
            <div class="contact show-for-large float-left">
                <span class="enun @if ($property->gestor) gestor @endif">
                    @if ($property->gestor)
                        {{ trans('messages.words.gestor') }}
                    @else
                        {{ trans('messages.app.contact.verb') }}
                    @endif
                </span>
                <div class="name display-inline-bottom">
                    <span>{{ $action->contact->names }}</span>
                </div>
                <div class="read-more">
                    <?php $phone = explode(',', $action->contact->phones); ?>
                    <span>{{ $phone[0] }}</span>
                </div>
            </div>
        @endif
    </div>
    <div class="clear"></div>
    <div class="more-details">
        <div class="details-menu">
            <!--            <a><i class="fa fa-facebook-official"></i></a> |            <a class="simple"><i class="fa fa-info"></i> {{ trans('messages.app.see.details') }}</a>            -->
        </div>
        <div class="gallery-container"></div>
        <div class="clear"></div>
        <div class="close-menu">
            <a href="#" class="close-details secondary hollow button">{{ trans('messages.words.close') }}</a>
        </div>
    </div>
</article>

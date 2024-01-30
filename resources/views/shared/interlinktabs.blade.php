<div class="row tabspanels">
    <ul class="tabs" data-tabs id="main-tabs">
        <li class="tabs-title {{ $tab_active == 'index' ? 'is-active' : '' }}">
            @if ($tab_active != 'index')
                <a data-tabs-target="panelMoreFinded" href="{{ \App\Helper::getPathfor('/') }}"
                    onclick="location.href = '{{ \App\Helper::getPathfor('/') }}'">{{ trans('messages.app.morefinded') }}</a>
            @else
                <a data-tabs-target="panelMoreFinded">{{ trans('messages.app.morefinded') }}</a>
            @endif
        </li>
        <li class="tabs-title {{ $tab_active == 'venta' ? 'is-active' : '' }}">
            @if ($tab_active != 'venta')
                <a data-tabs-target="panelSell"
                    href="{{ \App\Helper::getPathfor('venta/viviendas/') }}"
                    onclick="location.href = '{{ \App\Helper::getPathfor('venta/viviendas/') }}'">{{ trans('messages.actions.seek.buy') }}
                </a>
            @else
                <a data-tabs-target="panelSell">{{ trans('messages.actions.seek.buy') }}
                </a>
            @endif
        </li>
        <li class="tabs-title {{ $tab_active == 'permuta' ? 'is-active' : '' }}">
            @if ($tab_active != 'permuta')
                <a data-tabs-target="panelExchange"
                    href="{{ \App\Helper::getPathfor('permuta/viviendas/') }}"
                    onclick="location.href = '{{ \App\Helper::getPathfor('permuta/viviendas/') }}'">{{ trans('messages.actions.seek.exchange') }}
                @else
                    <a data-tabs-target="panelExchange">{{ trans('messages.actions.seek.exchange') }}
            @endif
            </a>
        </li>
    </ul>

    <div class="tabs-content" data-tabs-content="main-subtabs">
        <div class="tabs-panel {{ $tab_active == 'index' ? 'is-active' : '' }}" id="panelMoreFinded">
            @if ($tab_active == 'index')
                <div class="row">
                    <div class="small-12 medium-6 large-3 columns">
                        <ul class="inline-list ">
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Cuba">{{ trans('messages.words.sale.viviendas.in') }}
                                    Cuba</a></li>

                            @foreach ($provinces as $province)
                                <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                        href="{{ \App\Helper::getPathFor('venta/viviendas' . '/' . $province->slugged) }}"
                                        title="{{ trans('messages.words.sale.viviendas.in') }} {{ $province->name }}">{{ trans('messages.words.sale.viviendas.in') }}
                                        {{ $province->name }}</a></li>
                            @endforeach

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/apartamentos/la-habana/san-miguel-del-padron') }}"
                                    title="{{ trans('messages.words.sale.apartamento.in') }} San Miguel del Padron">{{ trans('messages.words.sale.apartamento.in') }}
                                    San Miguel</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/apartamentos/la-habana/habana-del-este') }}"
                                    title="{{ trans('messages.words.sale.apartamento.in') }} Habana del Este">{{ trans('messages.words.sale.apartamento.in') }}
                                    Habana del Este</a>
                            </li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/arroyo-naranjo') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Arroyo Naranjo">{{ trans('messages.words.sale.viviendas.in') }}
                                    Arroyo Naranjo</a>
                            </li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/apartamentos/la-habana/marianao') }}"
                                    title="{{ trans('messages.words.sale.apartamento.in') }} Marianao">{{ trans('messages.words.sale.apartamento.in') }}
                                    Marianao</a>
                            </li>

                        </ul>
                    </div>
                    <div class="small-12 medium-6 large-3 columns">
                        <ul class="inline-list ">
                            @foreach ($types as $type)
                                <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                        href="{{ \App\Helper::getPathFor('venta' . '/' . $type->sluggedplural) }}"
                                        title="{{ trans_choice('messages.words.sale', 1) }} {{ trans('messages.words.from') }} {{ trans_choice('messages.db.property.' . $type->slugged, 2) }}">{{ trans_choice('messages.words.sale', 1) }}
                                        {{ trans('messages.words.from') }}
                                        {{ trans_choice('messages.db.property.' . $type->slugged, 2) }}</a></li>
                            @endforeach


                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas?action=1&currency=1&order=cheap') }}"
                                    title="{{ trans('messages.app.sell.cheap.monedanacional') }}">{{ trans('messages.app.sell.cheap.cup') }}</a>
                            </li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas?action=1&currency=2&order=cheap') }}"
                                    title="{{ trans('messages.app.sell.cheap.dolares') }}">{{ trans('messages.app.sell.cheap.usd') }}</a>
                            </li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana?&order=cheap') }}"
                                    title="{{ trans('messages.app.sell.cheap.habana') }}">{{ trans('messages.app.sell.cheap.habana') }}</a>
                            </li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/apartamentos/la-habana?&order=cheap') }}"
                                    title="{{ trans('messages.app.sell.cheap.apartamentos.habana') }}">{{ trans('messages.app.sell.cheap.apartamentos.habana') }}
                                </a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana?&order=recent') }}"
                                    title="{{ trans('messages.words.sale.casa.in') }} La Habana 2022">{{ trans('messages.words.sale.casa.in') }}
                                    La Habana 2022
                                </a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas?action=1&extras%5B%5D=10') }}"
                                    title="{{ trans('messages.words.sale.casa.with') }} {{ trans('messages.db.extra.piscina.p') }}">{{ trans('messages.words.sale.houses.with') }}
                                    {{ trans('messages.db.extra.piscina.p') }}</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/playa') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} {{ trans('messages.words.municipio.lower') }} Playa">{{ trans('messages.words.sale.viviendas.in') }}
                                    {{ trans('messages.words.municipio.lower') }} Playa</a>
                            </li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/plaza-de-la-revolucion') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Plaza de la Revolución">{{ trans('messages.words.sale.viviendas.in') }}
                                    Plaza de la
                                    Revolución</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/san-miguel-del-padron?order=cheap') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in.sanmiguel.cheap') }}">{{ trans('messages.words.sale.viviendas.in.sanmiguel.cheap') }}</a>
                            </li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/cotorro') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} El Cotorro">{{ trans('messages.words.sale.viviendas.in') }}
                                    El Cotorro</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/matanzas/cardenas') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Cárdenas">{{ trans('messages.words.sale.viviendas.in') }}
                                    Cárdenas</a>
                            </li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/matanzas/colon') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Colón, Matanzas">{{ trans('messages.words.sale.viviendas.in') }}
                                    Colón, Matanzas</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/centro-habana') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Centro Habana">{{ trans('messages.words.sale.viviendas.in') }}
                                    Centro Habana</a>
                            </li>


                        </ul>
                    </div>
                    <div class="small-12 medium-6 large-3 columns">
                        <ul class="inline-list ">

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/apartamentos/la-habana/plaza-de-la-revolucion/vedado') }}"
                                    title="{{ trans('messages.words.sale.apartments.in.the') }} Vedado">{{ trans('messages.words.sale.apartments.in.the') }}
                                    Vedado</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/plaza-de-la-revolucion/vedado') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in.the') }} Vedado">{{ trans('messages.words.sale.viviendas.in.the') }}
                                    Vedado</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/diez-de-octubre/sevillano') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in.the') }} Sevillano">{{ trans('messages.words.sale.viviendas.in.the') }}
                                    Sevillano</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/cerro/casino-deportivo') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in.the') }} Casino Deportivo">{{ trans('messages.words.sale.viviendas.in.the') }}
                                    Casino Deportivo</a>
                            </li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/habana-del-este/guanabo') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Guanabo">{{ trans('messages.words.sale.viviendas.in.the') }}
                                    Guanabo</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/plaza-de-la-revolucion/nuevo-vedado') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Nuevo Vedado">{{ trans('messages.words.sale.viviendas.in') }}
                                    Nuevo Vedado</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/playa/siboney-playa') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Siboney, La Habana">{{ trans('messages.words.sale.viviendas.in') }}
                                    Siboney</a>
                            </li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/playa/santa-fe') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Santa Fe">{{ trans('messages.words.sale.viviendas.in') }}
                                    Santa Fe</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/playa/miramar') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Miramar">{{ trans('messages.words.sale.viviendas.in') }}
                                    Miramar</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/diez-de-octubre/santos-suarez') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Santo Suárez">{{ trans('messages.words.sale.viviendas.in') }}
                                    santo Suárez</a>
                            </li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/diez-de-octubre/vibora') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} La Víbora">{{ trans('messages.words.sale.viviendas.in') }}
                                    La Víbora</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/diez-de-octubre/monaco') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in.the') }} Mónaco">{{ trans('messages.words.sale.viviendas.in.the') }}
                                    Mónaco</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/la-lisa/san-agustin') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} San Agustín">{{ trans('messages.words.sale.viviendas.in') }}
                                    San Agustín</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/apartamentos/la-habana/la-lisa') }}"
                                    title="{{ trans('messages.words.sale.apartamento.in') }} La Lisa">{{ trans('messages.words.sale.apartamento.in') }}
                                    La Lisa</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/apartamentos/la-habana/habana-del-este/alamar-este') }}"
                                    title="{{ trans('messages.words.sale.apartamento.in') }} Alamar">{{ trans('messages.words.sale.apartamento.in') }}
                                    Alamar</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/la-lisa/versalles-coronela?order=cheap') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in.matanzas.cheap') }}">
                                    {{ trans('messages.words.sale.viviendas.in.matanzas.cheap') }}</a>
                            </li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/la-lisa') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} La Lisa">{{ trans('messages.words.sale.viviendas.in') }}
                                    La Lisa</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/diez-de-octubre') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} 10 de Octubre">{{ trans('messages.words.sale.viviendas.in') }}
                                    10 de Octubre</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/marianao') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Marianao">{{ trans('messages.words.sale.viviendas.in') }}
                                    Marianao</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/habana-vieja') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Habana Vieja">{{ trans('messages.words.sale.viviendas.in') }}
                                    Habana Vieja</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/guanabacoa') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Guanabacoa">{{ trans('messages.words.sale.viviendas.in') }}
                                    Guanabacoa</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/apartamentos/la-habana/guanabacoa') }}"
                                    title="{{ trans('messages.words.sale.apartamento.in') }} Guanabacoa">{{ trans('messages.words.sale.apartamento.in') }}
                                    Guanabacoa</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/regla') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Regla">{{ trans('messages.words.sale.viviendas.in') }}
                                    Regla</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/cerro') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} El Cerro">{{ trans('messages.words.sale.viviendas.in') }}
                                    El Cerro</a></li>
                        </ul>
                    </div>
                    <div class="small-12 medium-6 large-3 columns">
                        <ul class="inline-list ">
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas') }}"
                                    title="{{ trans('messages.words.permuta.only') }}">{{ trans('messages.words.permuta.only') }}
                                </a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana') }}"
                                    title="{{ trans('messages.words.permuta.in') }}">{{ trans('messages.words.permuta.in') }}
                                    La Habana
                                </a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana?action=2&condition=2x1&province=1') }}"
                                    title="{{ trans('messages.words.permuta.dosporuno.in') }} La Habana">{{ trans('messages.words.permuta.dosporuno.in') }}
                                    La Habana</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana?action=2&condition=1x2&province=1') }}"
                                    title="{{ trans('messages.words.permuta.unopordos.in') }} La Habana">{{ trans('messages.words.permuta.unopordos.in') }}
                                    La Habana</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas') }}"
                                    title="{{ trans('messages.words.permuta.houses') }}">{{ trans('messages.words.permuta.houses') }}</a>
                            </li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas?action=2&condition=1x2') }}"
                                    title="{{ trans('messages.words.permuta.houses') }} 1x2">{{ trans('messages.words.permuta.houses') }}
                                    1x2</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas?action=2&condition=2x1') }}"
                                    title="{{ trans('messages.words.permuta.houses') }} 2x1">{{ trans('messages.words.permuta.houses') }}
                                    2x1</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana') }}"
                                    title="{{ trans('messages.words.permuta.casa.in') }} La Habana">{{ trans('messages.words.permuta.casa.in') }}
                                    La Habana</a>
                            </li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana/marianao') }}"
                                    title="{{ trans('messages.words.permuta.in') }} Marianao">{{ trans('messages.words.permuta.in') }}
                                    Marianao</a></li>

                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana/plaza-de-la-revolucion/vedado') }}"
                                    title="{{ trans('messages.words.permuta.in.the') }} Vedado">{{ trans('messages.words.permuta.in.the') }}
                                    Vedado</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana/centro-habana') }}"
                                    title="{{ trans('messages.words.permuta.in') }} Centro Habana">{{ trans('messages.words.permuta.in') }}
                                    Centro Habana</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana/playa') }}"
                                    title="{{ trans('messages.words.permuta.in.municipality.playa') }}">{{ trans('messages.words.permuta.in.municipality.playa') }}</a>
                            </li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana/cerro') }}"
                                    title="{{ trans('messages.words.permuta.in') }} El Cerro">{{ trans('messages.words.permuta.in') }}
                                    El Cerro</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana/diez-de-octubre') }}"
                                    title="{{ trans('messages.words.permuta.in') }} 10 de Octubre">{{ trans('messages.words.permuta.in') }}
                                    10 de Octubre</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana/boyeros') }}"
                                    title="{{ trans('messages.words.permuta.in') }} Boyeros">{{ trans('messages.words.permuta.in') }}
                                    Boyeros</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/la-habana/habana-del-este/alamar-este') }}"
                                    title="{{ trans('messages.words.permuta.in') }} Alamar">{{ trans('messages.words.permuta.in') }}
                                    Alamar</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/apartamentos/la-habana/boyeros/altahabana-capdevila') }}"
                                    title="{{ trans('messages.words.permuta.apartamento.in') }} Altahabana">{{ trans('messages.words.permuta.apartamento.in') }}
                                    Altahabana</a>
                            </li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/apartamentos/la-habana/la-lisa') }}"
                                    title="{{ trans('messages.words.permuta.apartamento.in') }} La Lisa">{{ trans('messages.words.permuta.apartamento.in') }}
                                    La Lisa</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/la-lisa?order=cheap') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in.lalisa.cheap') }}">{{ trans('messages.words.sale.viviendas.in.lalisa.cheap') }}</a>
                            </li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/boyeros') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Boyeros">{{ trans('messages.words.sale.viviendas.in') }}
                                    Boyeros</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/playa') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in.municipality.playa') }}">{{ trans('messages.words.sale.viviendas.in.municipality.playa') }}</a>
                            </li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/la-habana/boyeros/altahabana-capdevila') }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} Altahabana">{{ trans('messages.words.sale.viviendas.in') }}
                                    Altahabana</a></li>
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/apartamentos/la-habana') }}"
                                    title="{{ trans('messages.words.sale.apartamento.in') }} La Habana">{{ trans('messages.words.sale.apartamento.in') }}
                                    La Habana</a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
        <div class="tabs-panel {{ $tab_active == 'permuta' ? 'is-active' : '' }}" id="panelExchange">
            <div class="row">
                @if ($tab_active != 'index')
                    <ul class="tabs" data-tabs id="permuta-tabs">
                        <li class="tabs-title subtab {{ $subtab_active == 'viviendas' ? 'is-active' : '' }}">
                            @if ($subtab_active != 'viviendas')
                                <a data-tabs-target="viviendas"
                                    href="{{ \App\Helper::getPathfor('permuta/viviendas/') }}"
                                    onclick="location.href = '{{ \App\Helper::getPathfor('permuta/viviendas/') }}'">{{ trans_choice('messages.db.property.viviendas', 1) }}
                                </a>
                            @else
                                <a data-tabs-target="viviendas">{{ trans_choice('messages.db.property.viviendas', 1) }}
                                </a>
                            @endif
                        </li>
                        @foreach ($types as $type)
                            <li
                                class="tabs-title subtab {{ $subtab_active == $type->sluggedplural ? 'is-active' : '' }}">
                                @if ($subtab_active != $type->sluggedplural)
                                    <a data-tabs-target="{{ $type->sluggedplural }}"
                                        href="{{ \App\Helper::getPathfor('permuta/' . $type->sluggedplural . '/') }}"
                                        onclick="location.href = '{{ \App\Helper::getPathfor('permuta/' . $type->sluggedplural . '/') }}'">{{ trans_choice('messages.db.property.' . $type->slugged, 1) }}</a>
                                @else
                                    <a
                                        data-tabs-target="{{ $type->sluggedplural }}">{{ trans_choice('messages.db.property.' . $type->slugged, 1) }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="tabs-panel {{ $subtab_active == 'viviendas' ? 'is-active' : '' }}" id="viviendas">

                    <ul class="inline-list sui-ListLink">
                        @foreach ($provinces as $province)
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('permuta/viviendas/' . $province->slugged) }}"
                                    title="{{ trans('messages.words.permuta.viviendas.in') }} {{ $province->name }}">{{ trans('messages.words.permuta.viviendas.in') }}
                                    {{ $province->name }}</a></li>
                        @endforeach
                    </ul>

                </div>

                @foreach ($types as $type)
                    <div class="tabs-panel {{ $subtab_active == $type->sluggedplural ? 'is-active' : '' }}"
                        id="{{ $type->sluggedplural }}">
                        @if ($subtab_active == $type->sluggedplural)
                            <ul class="inline-list sui-ListLink">
                                @foreach ($provinces as $province)
                                    <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                            href="{{ \App\Helper::getPathFor('permuta/' . $type->sluggedplural . '/' . $province->slugged) }}"
                                            title="{{ trans('messages.words.permuta.' . $type->slugged . '.in') }} {{ $province->name }}">{{ trans('messages.words.permuta.' . $type->slugged . '.in') }}
                                            {{ $province->name }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
        <div class="tabs-panel {{ $tab_active == 'venta' ? 'is-active' : '' }}" id="panelSell">
            <div class="row">
                @if ($tab_active != 'index')
                    <ul class="tabs" data-tabs id="sell-tabs">
                        <li class="tabs-title subtab {{ $subtab_active == 'viviendas' ? 'is-active' : '' }}">
                            @if ($subtab_active != 'viviendas')
                                <a data-tabs-target="viviendas"
                                    href="{{ \App\Helper::getPathfor('venta/viviendas/') }}"
                                    onclick="location.href = '{{ \App\Helper::getPathfor('venta/viviendas/') }}'">{{ trans_choice('messages.db.property.viviendas', 1) }}
                                </a>
                            @else
                                <a data-tabs-target="viviendas">{{ trans_choice('messages.db.property.viviendas', 1) }}
                                </a>
                            @endif
                        </li>
                        @foreach ($types as $type)
                            <li
                                class="tabs-title subtab {{ $subtab_active == $type->sluggedplural ? 'is-active' : '' }}">
                                @if ($subtab_active != $type->sluggedplural)
                                    <a data-tabs-target="{{ $type->sluggedplural }}"
                                        href="{{ \App\Helper::getPathfor('venta/' . $type->sluggedplural . '/') }}"
                                        onclick="location.href = '{{ \App\Helper::getPathfor('venta/' . $type->sluggedplural . '/') }}'">{{ trans_choice('messages.db.property.' . $type->slugged, 1) }}</a>
                                @else
                                    <a
                                        data-tabs-target="{{ $type->sluggedplural }}">{{ trans_choice('messages.db.property.' . $type->slugged, 1) }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="tabs-panel {{ $subtab_active == 'viviendas' ? 'is-active' : '' }}" id="viviendas">

                    <ul class="inline-list sui-ListLink">
                        @foreach ($provinces as $province)
                            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                    href="{{ \App\Helper::getPathFor('venta/viviendas/' . $province->slugged) }}"
                                    title="{{ trans('messages.words.sale.viviendas.in') }} {{ $province->name }}">{{ trans('messages.words.sale.viviendas.in') }}
                                    {{ $province->name }}</a></li>
                        @endforeach
                    </ul>

                </div>

                @foreach ($types as $type)
                    <div class="tabs-panel {{ $subtab_active == $type->sluggedplural ? 'is-active' : '' }}"
                        id="{{ $type->sluggedplural }}">
                        @if ($subtab_active == $type->sluggedplural)
                            <ul class="inline-list sui-ListLink">
                                @foreach ($provinces as $province)
                                    <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                                            href="{{ \App\Helper::getPathFor('venta/' . $type->sluggedplural . '/' . $province->slugged) }}"
                                            title="{{ trans('messages.words.sale.' . $type->slugged . '.in') }} {{ $province->name }}">{{ trans('messages.words.sale.' . $type->slugged . '.in') }}
                                            {{ $province->name }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

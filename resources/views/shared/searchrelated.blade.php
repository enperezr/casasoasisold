
<div class="row">
    <div class="re-SearchRelated">
        <h2 class="re-SearchRelated-title">
            @if ($taction->slugged == 'venta')
            Resultados relacionados con la {{ trans_choice('messages.words.sale', 1) }} {{ trans('messages.words.from') }} {{ trans_choice('messages.db.property.' . $ttypeslugged, 2) .' ' .trans('messages.words.in') .' ' .$placeRela->name }}
            @else
            Resultados relacionados con la {{ trans_choice('messages.words.permuta', 1) }} {{ trans('messages.words.from') }} {{ trans_choice('messages.db.property.' . $ttypeslugged, 2) }} {{ trans('messages.words.in') . ' ' . $placeRela->name }}
            @endif
        </h2>
              
        @if($taction->slugged == 'venta')

        <ul class="re-SearchRelated-list">
              
            @if((\App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'venta','apartamentos') . '?order=cheap' ) != (Request::fullUrl()) )
             <li class="re-SearchRelated-item"><a                   
                    href="{{ \App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'venta','apartamentos') . '?order=cheap' }}"                    
                    class="sui-AtomTag-actionable sui-AtomTag sui-AtomTag-medium sui-AtomTag--outline"
                    role="button"><span class="sui-AtomTag-label"
                        title="{{ trans('messages.app.sell.cheap.apartamentos.in') }} {{ $placeRela->name }}">{{ trans('messages.app.sell.cheap.apartamentos.in') }}
                        {{ $placeRela->name }} </span></a></li> 
            @endif         

            @if((\App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'venta','viviendas')) != (Request::fullUrl()))
            <li class="re-SearchRelated-item"><a
                    href="{{ \App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'venta','viviendas') }}"
                    class="sui-AtomTag-actionable sui-AtomTag sui-AtomTag-medium sui-AtomTag--outline"
                    role="button"><span class="sui-AtomTag-label"
                        title="{{ trans('messages.words.sale.viviendas.in') }} {{ $placeRela->name }}">{{ trans('messages.words.sale.viviendas.in') }}
                        {{ $placeRela->name }}</span></a>
            </li>
            @endif

            @if((\App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'venta','casas-independientes')) != (Request::fullUrl()))
            <li class="re-SearchRelated-item"><a
                    href="{{ \App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'venta','casas-independientes') }}"
                    class="sui-AtomTag-actionable sui-AtomTag sui-AtomTag-medium sui-AtomTag--outline"
                    role="button"><span class="sui-AtomTag-label"
                        title="{{ trans('messages.words.sale.casa-independiente.in') }} {{ $placeRela->name }}">{{ trans('messages.words.sale.casa-independiente.in') }}
                        {{ $placeRela->name }}</span></a></li>
            @endif

            @if((\App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'venta','viviendas') . '?order=cheap') != (Request::fullUrl()))
            <li class="re-SearchRelated-item"><a
                    href="{{ \App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'venta','viviendas') . '?order=cheap' }}"
                    class="sui-AtomTag-actionable sui-AtomTag sui-AtomTag-medium sui-AtomTag--outline"
                    role="button"><span class="sui-AtomTag-label"
                        title="{{ trans('messages.words.sale.viviendas.cheap.in') }} {{ $placeRela->name }}">{{ trans('messages.words.sale.viviendas.cheap.in') }}
                        {{ $placeRela->name }}</span></a></li>
            @endif        
              
        </ul>

        @else

        <ul class="re-SearchRelated-list">
                     
            @if((\App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'permuta','viviendas')) != (Request::fullUrl()))
            <li class="re-SearchRelated-item"><a
                    href="{{ \App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'permuta','viviendas') }}"
                    class="sui-AtomTag-actionable sui-AtomTag sui-AtomTag-medium sui-AtomTag--outline"
                    role="button"><span class="sui-AtomTag-label"
                        title="{{ trans('messages.words.permuta.viviendas.in') }} {{ $placeRela->name }}">{{ trans('messages.words.permuta.viviendas.in') }}
                        {{ $placeRela->name }}</span></a></li>
            @endif

            @if((\App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'permuta','viviendas') . '?action=2&condition=2x1&province=' . $tprovince->id) != (Request::fullUrl()))
            <li class="re-SearchRelated-item"><a
                    href="{{ \App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'permuta','viviendas') . '?action=2&condition=2x1&province=' . $tprovince->id }}"
                    class="sui-AtomTag-actionable sui-AtomTag sui-AtomTag-medium sui-AtomTag--outline"
                    role="button"><span class="sui-AtomTag-label"
                        title="{{ trans('messages.words.permuta.dosporuno.in') }} {{ $placeRela->name }}">{{ trans('messages.words.permuta.dosporuno.in') }}
                        {{ $placeRela->name }}</span></a></li>
            @endif

            @if((\App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'permuta','viviendas'). '?action=2&condition=1x2&province=' . $tprovince->id) != (Request::fullUrl()))
            <li class="re-SearchRelated-item"><a
                    href="{{ \App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'permuta','viviendas'). '?action=2&condition=1x2&province=' . $tprovince->id }}"
                    class="sui-AtomTag-actionable sui-AtomTag sui-AtomTag-medium sui-AtomTag--outline"
                    role="button"><span class="sui-AtomTag-label"
                        title="{{ trans('messages.words.permuta.unopordos.in') }} {{ $placeRela->name }}">{{ trans('messages.words.permuta.unopordos.in') }}
                        {{ $placeRela->name }}</span></a></li>
            @endif
            
            @if((\App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'permuta','apartamentos')) != (Request::fullUrl()))
            <li class="re-SearchRelated-item"><a
                    href="{{\App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,'permuta','apartamentos') }}"
                    class="sui-AtomTag-actionable sui-AtomTag sui-AtomTag-medium sui-AtomTag--outline"
                    role="button"><span class="sui-AtomTag-label"
                        title="{{ trans('messages.words.permuta.apartamento.in') . ' ' . $placeRela->name }}">{{ trans('messages.words.permuta.apartamento.in') }}
                        {{ $placeRela->name }}</span></a></li>
            @endif
        </ul>

        @endif
        
       
    </div>
</div>

<div class="row">
  <div class="midleSearchRelated"> 
    <div class="small-12 medium-6 large-4 columns">
        <h2 class="re-SearchRelated-title"> Encuentra más inmuebles en {{ $placeRela->name }}</h2>
        <ul>
            @foreach ($types as $type)
            @if((\App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,$taction->slugged,$type->sluggedplural)) != (Request::fullUrl()))   
            <li class="sui-ListLink-item"><a class="sui-LinkBasic"
                    
                        href="{{ \App\Helper::getPathForPlace($tprovince,$tmunicipio,$tlocality,$taction->slugged,$type->sluggedplural) }}"
                        @if ($taction->slugged == 'venta') title="{{ trans_choice('messages.words.sale', 1) }} {{ trans('messages.words.from') }} {{ trans_choice('messages.db.property.' . $type->slugged, 2) }} {{ trans('messages.words.in') . ' ' . $placeRela->name }}">
                          {{ trans_choice('messages.words.sale', 1) .' ' .trans('messages.words.from') .' ' .trans_choice('messages.db.property.' . $type->slugged, 2) .' ' .trans('messages.words.in') .' ' .$placeRela->name }}
                        @else
                        title="{{ trans_choice('messages.words.permuta', 1) }} {{ trans('messages.words.from') }} {{ trans_choice('messages.db.property.' . $type->slugged, 2) }} {{ trans('messages.words.in') . ' ' . $placeRela->name }}">
                        {{ trans_choice('messages.words.permuta', 1) .' ' .trans('messages.words.from') .' ' .trans_choice('messages.db.property.' . $type->slugged, 2) .' ' .trans('messages.words.in') .' ' .$placeRela->name }}
                        @endif
                        </a></li>

            @endif
            @endforeach
        </ul>
    </div>
    <div class="small-12 medium-6 large-8 columns">
        <h2 class="re-SearchRelated-title"> {{ trans_choice('messages.db.property.' . $ttypeslugged, 2) }} en municipios de {{ $tprovince->name }}</h2>
        <ul>           
            @foreach ($municipios as $municipio)
            @if($tmunicipio!=$municipio) 
                <li class="sui-ListLink-item large-6 columns"><a class="sui-LinkBasic"
                        href="{{ App\Helper::getPathForPlace($tprovince,$municipio,null,$taction->slugged,$ttypeslugged) }}"
                        @if ($taction->slugged == 'venta') title="{{ trans_choice('messages.words.sale', 1) }} {{ trans('messages.words.from') }} {{ trans_choice('messages.db.property.' . $ttypeslugged, 2) }} {{ trans('messages.words.in') . ' ' . $municipio->name }}">
                          {{ trans_choice('messages.words.sale', 1) .' ' .trans('messages.words.from') .' ' .trans_choice('messages.db.property.' . $ttypeslugged, 2) .' ' .trans('messages.words.in') .' ' .$municipio->name }}
                        @else
                        title="{{ trans_choice('messages.words.permuta', 1) }} {{ trans('messages.words.from') }} {{ trans_choice('messages.db.property.' . $ttypeslugged, 2) }} {{ trans('messages.words.in') . ' ' . $municipio->name }}">
                        {{ trans_choice('messages.words.permuta', 1) .' ' .trans('messages.words.from') .' ' .trans_choice('messages.db.property.' . $ttypeslugged, 2) .' ' .trans('messages.words.in') .' ' .$municipio->name }} 
                        @endif
                        </a></li>
            @endif
            @endforeach
        </ul>
    </div>
  </div>
</div>
@if($tmunicipio)
<div class="row">
    <div class="re-moreHomesFooter">
      <h2 class="re-SearchRelated-title">Más {{ trans_choice('messages.db.property.' . $ttypeslugged, 2) }} en las localidades de {{ $tmunicipio->name }}</h2>
        <div style="max-height: none;">
                    <div>
                        <ul class="ListLink">
                           @foreach ($localities as $locality)
                           @if ($taction->slugged == 'venta')
                           @if(App\Helper::getPathForPlace($tprovince,$tmunicipio,$locality,$taction->slugged,$ttypeslugged) != Request::fullUrl())
                           <li class="listLink-item"><a class="linkBasic"
                            href="{{ App\Helper::getPathForPlace($tprovince,$tmunicipio,$locality,$taction->slugged,$ttypeslugged) }}"
                            title="{{ trans_choice('messages.words.sale', 1) .' ' .trans('messages.words.from') .' ' .trans_choice('messages.db.property.' . $ttypeslugged, 2) .' ' .trans('messages.words.in') .' '. ($locality->name == 'unspecified' ? 'otros' : $locality->name)}} ">{{ trans_choice('messages.words.sale', 1) .' ' .trans('messages.words.from') .' ' .trans_choice('messages.db.property.' . $ttypeslugged, 2) .' ' .trans('messages.words.in') .' '. ($locality->name == 'unspecified' ? 'otros' : $locality->name)}} </a></li>
                           @endif
                            @else
                            @if(App\Helper::getPathForPlace($tprovince,$tmunicipio,$locality,$taction->slugged,$ttypeslugged) != Request::fullUrl())
                           <li class="listLink-item"><a class="linkBasic"
                            href="{{ App\Helper::getPathForPlace($tprovince,$tmunicipio,$locality,$taction->slugged,$ttypeslugged) }}"
                            title="{{ trans_choice('messages.words.permuta', 1) .' ' .trans('messages.words.from') .' ' .trans_choice('messages.db.property.' . $ttypeslugged, 2) .' ' .trans('messages.words.in') .' '. ($locality->name == 'unspecified' ? 'otros' : $locality->name)}} ">{{ trans_choice('messages.words.permuta', 1) .' ' .trans('messages.words.from') .' ' .trans_choice('messages.db.property.' . $ttypeslugged, 2) .' ' .trans('messages.words.in') .' '. ($locality->name == 'unspecified' ? 'otros' : $locality->name)}} </a></li>
                           @endif
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
          </div>
</div>
@endif

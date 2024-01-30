@section('styles')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/guide.css') }}">
@endsection
@extends($apk ? 'layout.apk' : 'layout.master')
@section('title', trans('messages.actions.publish.title'))
@section('description', trans('messages.app.publish.description'))
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('google')
    @include('portal.google-ads')
@endsection
@section('content')
    <div class="container">
        @include('portal.ads', ['place'=>'4'])
        <div class="row text-center">
            <h1 id="chooseTitle">{{ trans('messages.app.select.plan') }}</h1>
        </div>
        <div class="row plans">
            @foreach ($plans as $plan)
                <div class="large-3 large-offset-1 columns">
                   @if($plan->id == 2)
                        <div class="callout text-center  plan @if ($plan->id == 3) infinite @endif">

                            <div id="planheaderinterm">
                                <h3 class="days{{ $plan->id }}">{!! trans('messages.app.plan.basic') !!}</h3>
                            </div>
                            <div class="picointerm">
                            </div>

                            <h3 class="intermplan">{{ $plan->price }} CUP</h3>

                            <div class="bodyplan">
                                <ul>
                                    <li class="ofert">{!! trans('messages.app.plan.intermediate.ofert1') !!}</li>
                                    <li class="ofert">{!! trans('messages.app.plan.common.ofert15') !!}</li>                                   
                                    <li class="ofert">
                                    {!! trans('messages.app.plan.common.ofert18') !!}
                                        <ul>
                                           <li class="ofert">{!! trans('messages.app.plan.common.ofert16') !!}</li>
                                        </ul>
                                    </li>
                                    <!--                                 
                                    <li class="ofertnonorm">
                                       
                                        <ul>                                            
                                            <li class="ofertno">{!! trans('messages.app.plan.common.ofert9') !!}</li>
                                            <li class="ofertno">{!! trans('messages.app.plan.common.ofert10') !!}</li>
                                        </ul>
                                    </li>-->
                                </ul>
                            </div>

                            <a id="b{{ $plan->id }}"
                                href="{{ \App\Helper::getPathFor('nueva/propiedad' . ($apk ? '/' . $apk : '') . '?plan=' . $plan->days) }}"
                                class="button">{{ trans('messages.words.choose') }}</a>
                        </div>
                    @elseif($plan->id == 3)
                        <div class="callout text-center  plan @if ($plan->id == 3) infinite @endif">

                            <div id="planheaderavan">
                                <h3 class="days{{ $plan->id }}">{!! trans('messages.app.plan.intermediate') !!}</h3>
                            </div>
                            <div class="picoavan">
                            </div>

                            <h3 class="avanplan">{{ $plan->price }} CUP</h3>

                            <div class="bodyplan">
                                <ul>
                                    <li class="ofert">{!! trans('messages.app.plan.advanced.ofert1') !!}</li>
                                    <li class="ofert">{!! trans('messages.app.plan.common.ofert15') !!}</li>                                 
                                    <li class="ofert">
                                    {!! trans('messages.app.plan.common.ofert18') !!}
                                        <ul>
                                           <li class="ofert">{!! trans('messages.app.plan.common.ofert16') !!}</li>
                                           <li class="ofert">{!! trans('messages.app.plan.common.ofert17') !!}</li>
                                        </ul>
                                    </li>  
                                </ul>
                            </div>

                            <a id="b{{ $plan->id }}"
                                href="{{ \App\Helper::getPathFor('nueva/propiedad' . ($apk ? '/' . $apk : '') . '?plan=' . $plan->days) }}"
                                class="button">{{ trans('messages.words.choose') }}</a>
                        </div>
                    @elseif($plan->id == 4)
                        <div class="callout text-center  plan @if ($plan->id == 3) infinite @endif">

                            <div class="planheadermax">
                                <h3 class="days{{ $plan->id }}">{!! trans('messages.app.plan.maximum') !!}</h3>
                            </div>
                            <div class="picomax">
                            </div>

                            <h3 class="maxplan">{{ $plan->price }} CUP</h3>

                            <div class="bodyplan">
                                <ul>

                                    <li class="ofert">
                                    {!! trans('messages.app.plan.max.ofert8') !!}
                                        <ul>
                                           <li class="ofert">{!! trans('messages.app.plan.max.ofert9') !!}</li>
                                           <li class="ofert">{!! trans('messages.app.plan.max.ofert10') !!}</li>
                                        </ul>
                                    </li>

                                    <li class="ofert">{!! trans('messages.app.plan.max.ofert1') !!}</li>
                                    <li class="ofert">{!! trans('messages.app.plan.common.ofert15') !!}</li>
                                    
                                    <li class="ofert">
                                    {!! trans('messages.app.plan.common.ofert18') !!}
                                        <ul>
                                           <li class="ofert">{!! trans('messages.app.plan.max.ofert2') !!}</li>
                                           <li class="ofert">{!! trans('messages.app.plan.max.ofert3') !!}</li>
                                           <li class="ofert">{!! trans('messages.app.plan.max.ofert4') !!}</li>
                                           <li class="ofert">{!! trans('messages.app.plan.max.ofert5') !!}</li>
                                           <li class="ofert">{!! trans('messages.app.plan.max.ofert6') !!}</li>
                                           <li class="ofert">{!! trans('messages.app.plan.max.ofert7') !!}</li>
                                        </ul>
                                    </li>                              
                                </ul>
                            </div>

                            <a id="b{{ $plan->id }}"
                                href="{{ \App\Helper::getPathFor('nueva/propiedad' . ($apk ? '/' . $apk : '') . '?plan=' . $plan->days) }}"
                                class="button">{{ trans('messages.words.choose') }}</a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="row"></div>
    </div>

@endsection

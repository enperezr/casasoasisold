@section('styles')
    <link rel="stylesheet" href="{{asset('css/forms.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/dropzone/css/basic.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/summernote/summernote-lite.css')}}">
    <link rel="stylesheet" href="{{asset('css/guide.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('vendor/dropzone/js/dropzone.js')}}"></script>
    <script src="{{asset('vendor/summernote/summernote-lite.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script src="{{asset('js/helpers-dist.js')}}"></script>
    <script src="{{asset('js/translator.js')}}"></script>
    <script src="{{asset('js/create-contact.js')}}"></script>
    <script src="{{asset('js/create-action.js')}}"></script>
    <script src="{{asset('js/create-property.js')}}"></script>
    <script src="{{asset('js/user-guide.js')}}"></script>
    @if(!Auth::user())
    <script type="text/javascript">
    $(function(){
        var popup = new Foundation.Reveal($('#myModal'),{
            closeOnClick:false,
        });
        popup.open();
        $('.reveal-overlay').click(function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
        });
        $('#accept-and-close').click(function(e){
            e.preventDefault();
            popup.close();
        });
    });
    </script>
    @endif
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
        <div class="row" id="guide">
            <div class="float-left">
                <ul class="inline-list float-left" id="numbers">
                    <li class="first active">1</li>
                    <li class="second">2</li>
                    <li class="third">3</li>
                </ul>
            </div>
        </div>
        <div class="row block-form hidden contact">
            <form class="formulario create" id="contact-form" method="post" action="{{\App\Helper::getPathFor('user/save-contact')}}">
                {!! csrf_field() !!}
                <input type="hidden" value="{{$contact ? $contact->id : ''}}" name="id"/>
                <input type="hidden" name="apk" value="{{$apk}}"/>
                <div class="form-content" id="contact-info">
                    <h1 class="title">{{trans('messages.app.contact.data')}}</h1>
                    <h6 class="description">{{trans('messages.app.contact.data.description')}}</h6>

                        @if(Auth::user() && (Auth::user()->rol_id == 2 || Auth::user()->rol_id == 4))
                            <div class="row fieldset" style="background: rgba(232,232,232,0.4)">
                                <div class="medium-6 columns">
                                    <label for="gestor">Usar Gestor</label>
                                    <select name="gestor" id="gestor">
                                        <option value="">No</option>
                                        @foreach($gestors as $gestor)
                                        <option value="{{$gestor->id}}" data-names="{{$gestor->gestor_contact->names}}" data-phones="{{$gestor->gestor_contact->phones}}" data-email="{{$gestor->gestor_contact->mail}}">{{$gestor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="medium-6 columns">
                                    <label for="provider">Usar Proveedor</label>
                                    <select name="provider" id="provider">
                                        <option value="">No</option>
                                        @foreach($providers as $provider)
                                            <option value="{{$provider->id}}">{{$provider->name}}({{$provider->rol->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                    <div class="row">
                        <div class="@if(Auth::user()) medium-4 @else medium-6 @endif columns first">
                            <label for="names">{{trans_choice('messages.words.name',2)}}</label>
                            <input type="text" id="names" name="names" data-validate-func="required|alphaEnumerator" data-validate-hint="{{trans('messages.app.validator.letters.enumerator')}}">
                        </div>
                        <div class="@if(Auth::user()) medium-4 @else medium-6 @endif columns">
                            <label for="phones">{{trans_choice('messages.words.phone',2)}}</label>
                            <input type="text" id="phones" name="phones" data-validate-func="required|digitsEnumerator" data-validate-hint="{{trans('messages.app.validator.digits.enumerator')}}">
                        </div>
                        @if(Auth::user())
                        <div class="medium-4 columns">
                            <label for="plan">{{trans('messages.app.time.accredited')}} </label>
                            <select name="plan" id="plan">
                                @foreach($plans as $plane)
                                    <option value="{{$plane->id}}" @if(isset($plan) && $plan->id == $plane->id) selected @endif>{{($plane->days > 2 * 365 ? trans('messages.app.no.time.limit') : intval($plane->days/30).' '.trans_choice('formats.month',2)).' x '.$plane->price.' CUC'}}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                            <input type="hidden" name="plan" value="{{$plan->id}}"/>
                        @endif
                        <div class="medium-12 columns">
                            <label for="mail">{{trans_choice('messages.words.mail',1)}} </label>
                            <input type="text" id="mail" name="mail" data-validate-func="email" data-validate-hint="{{trans('messages.app.validator.email')}}">
                        </div>
                    </div>
                    <div class="row text-center controls">
                        <a href="#" class="next button background-ho" id="continue1">{{trans('messages.app.continue')}}</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="row block-form hidden action" >
            <form class="formulario create" id="action-form" method="post" action="{{\App\Helper::getPathFor('user/save-action')}}">
                {!! csrf_field() !!}
                <input type="hidden" value="{{$action ? $action->id : ''}}" name="id"/>
                <div class="form-content" id="property-info">
                    <h1 class="title">{{trans('messages.app.action.data')}}</h1>
                    <h6 class="description">{{trans('messages.app.action.data.description')}}</h6>
                    <div class="row">
                        <div class="medium-4 columns">
                            <label for="action">{{trans_choice('messages.words.action', 1)}}</label>
                            <select name="action" id="action">
                                @foreach($actions as $a)
                                    @if($a->id < 3)
                                        <option value="{{$a->id}}">{{trans('messages.db.action.'.$a->slugged)}}</option>
                                    @endif
                                @endforeach
                                    <option value="4">{{trans('messages.db.action.vender-permutar')}}</option>
                            </select>
                        </div>
                        <div class="medium-4 columns ventas rentas">
                            <label for="price">{{trans_choice('messages.words.price', 1)}}</label>
                            <input type="text" name="price" id="price" data-validate-func="number" data-validate-hint="{{trans('messages.app.validator.number')}}">
                        </div>
                        <div class="medium-4 columns ventas">
                            <label for="currency">{{trans_choice('messages.words.currency', 1)}}</label>
                            <select name="currency" id="currency">
                                @foreach($currencies as $a)
                                   <option value="{{$a->id}}">{{trans($a->slugged)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="medium-4 columns rentas" style="display: none">
                            <label for="frequency">{{trans_choice('messages.words.frequency', 1)}}</label>
                            <select name="frequency" id="frequency">
                                <option value="1">{{trans('messages.words.frequency.1')}}</option>
                                <option value="7">{{trans('messages.words.frequency.7')}}</option>
                                <option value="30">{{trans('messages.words.frequency.30')}}</option>
                                <option value="365">{{trans('messages.words.frequency.365')}}</option>
                            </select>
                        </div>
                        <div class="medium-4 columns permutas" style="display: none">
                            <label for="option">{{trans_choice('messages.words.option', 1)}}</label>
                            <select name="option" id="option">
                                <option value="1x1">1x1</option>
                                <option value="1x2">1x2</option>
                                <option value="1x3">1x3</option>
                                <option value="2x1">2x1</option>
                                <option value="3x1">3x1</option>
                                <option value="3x2">3x2</option>
                                <option value="2x3">2x3</option>
                            </select>
                        </div>
                        <div class="large-12 columns permutas">
                            <label for="descriptionP">{{trans('messages.words.description.permuta')}}({{trans('messages.actions.permutar.description')}})</label>
                            <textarea name="descriptionP" id="descriptionP" class="editor"></textarea>
                        </div>
                        <!--<div class="large-12 columns ventas">
                            <label for="descriptionV">{{trans('messages.words.description.venta')}}</label>
                            <textarea name="descriptionV" id="descriptionV" class="editor"></textarea>
                        </div>-->
                        <div class="large-12 columns rentas services" style="display: none">
                            <label for="services">{{trans('messages.app.has.services')}}</label>
                            @foreach($services as $service)
                                <div class="option">
                                    <span><input type="checkbox" value="{{$service->id}}" name="services[]"/></span>
                                    <span>{{trans('messages.db.service.'.$service->slugged)}}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="large-12 columns text-center controls">
                            <a href="#" class="next button background-green" id="back1">{{trans('messages.words.back')}}</a>
                            <a href="#" class="next button background-ho" id="continue2">{{trans('messages.app.continue')}}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row block-form hidden inmueble" >
            <form class="formulario create" id="property-form">
                <input type="hidden" name="id" value="{{$property->id or ''}}">
                <div class="form-content" id="property-info">
                    <h1 class="title">{{trans('messages.app.property.data')}}</h1>
                    <h6 class="description">{{trans('messages.app.property.data.description')}}</h6>
                    <div class="row">
                        <div class="twelve columns">
                            <label for="description">{{trans('messages.words.description')}}</label>
                            <textarea name="description" id="description" class="editor">{{$property->description or ''}}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-4 columns">
                            <label for="province">{{trans_choice('messages.words.province', 1)}}</label>
                            <select name="province" id="province">
                                @foreach($provinces as $province)
                                    <option value="{{$province->id}}" @if(isset($property) && $province->id == $property->province_id) selected="selected" @endif>{{$province->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="medium-4 columns">
                            <label for="municipio">{{trans_choice('messages.words.municipio', 1)}}</label>
                            <select name="municipio" id="municipio">
                                @foreach($municipios as $mun)
                                    <option value="{{$mun->id}}" @if(isset($property) && $mun->id == $property->municipio_id) selected="selected" @endif>{{$mun->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="medium-4 columns">
                            <label for="locality">{{trans_choice('messages.words.locality', 1)}}</label>
                            <?php
                            $current = old('locality', isset($property) ? $property->locality_id : null);
                            if(!$current){
                                foreach ($localities as $loc){
                                    if($loc->name == 'unspecified'){
                                        $current = $loc->id;
                                        break;
                                    }
                                }
                            }
                            ?>
                            <select name="locality" id="locality">
                                @foreach($localities as $locality)
                                    <option class="dynamic" value="{{$locality->id}}" @if($locality->id == $current) selected="selected" @endif>{{$locality->name != 'unspecified' ? $locality->name : trans('messages.words.unspecified')}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <label for="address">{{trans('messages.words.address')}}</label>
                            <textarea id="address" name="address" data-validate-func="required" data-validate-hint="{{trans('messages.app.validator.required')}}">{{$property->address or ''}}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-3 columns">
                            <label for="type">{{trans('messages.app.property.type')}}</label>
                            <select name="type" id="type">
                                @foreach($types as $type)
                                    @if($type->id != 12){{-- TODO 12 is property registry used when the type of the property is nor defined--}}
                                    <option value="{{$type->id}}" data-group="{{$type->group_id}}" @if(isset($property) && $type->id == $property->property_type_id) selected="selected" @endif>{{trans_choice('messages.db.property.'.$type->slugged, 1)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="large-3 columns">
                            <label for="state">{{trans('messages.app.state.inmueble')}}</label>
                            <select name="state" id="state">
                                @foreach($states as $state)
                                    <option value="{{$state->id}}" @if(isset($property) && $state->id == $property->property_state_id) selected="selected" @endif>{{trans('messages.db.property.state.'.$state->slugged)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="large-3 columns">
                            <label for="rooms">{{trans_choice('messages.words.room',2)}}</label>
                            <input type="text" name="rooms" id="rooms" value="{{$property->rooms or 1}}" data-validate-func="required|number" data-validate-hint="{{trans(('messages.app.validator.number'))}}">
                        </div>
                        <div class="large-3 columns">
                            <label for="baths">{{trans_choice('messages.words.bath',2)}}</label>
                            <input type="text" name="baths" id="baths" value="{{$property->baths or 1}}" data-validate-func="required|number" data-validate-hint="{{trans(('messages.app.validator.number'))}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-4 columns">
                            <div>
                                <label for="highness">{{trans('messages.words.highness')}} <!--<a title="{{trans('messages.words.highness.help')}}"><i class="fa fa-info-circle"></i></a>--></label>
                                <input type="text" id="highness" name="highness" value="{{$property->highness or 1}}" data-validate-func="required|number" data-validate-hint="{{trans(('messages.app.validator.number'))}}">
                            </div>
                        </div>
                        <div class="large-4 columns">
                            <div class="comprar permutar">
                                <label for="construction">{{trans('messages.app.type.construction')}}</label>
                                <select name="construction" id="construction">
                                    @foreach($constructions as $construction)
                                        <option value="{{$construction->id}}" @if(isset($property) && $construction->id == $property->construction_type_id) selected="selected" @endif>{{trans('messages.db.construction.type.'.$construction->slugged)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="large-4 columns comprar permutar">
                            <label for="kitchen">{{trans('messages.app.kitchen.distribution')}}</label>
                            <select name="kitchen" id="kitchen">
                                @foreach($kitchen as $dist)
                                    <option value="{{$dist->id}}" @if(isset($property) && $dist->id == $property->kitchen_type_id) selected="selected" @endif>{{trans('messages.db.kitchen.'.$dist->slugged)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-4 columns">
                            <div class="comprar permutar">
                                <label for="floors">{{trans_choice('messages.words.floor',2)}} <!-- <a title="{{trans('messages.words.floor.help')}}"><i class="fa fa-info-circle"></i></a>--></label>
                                <input type="text" id="floors" name="floors" value="{{$property->floors or '1'}}" data-validate-func="number" data-validate-hint="{{trans(('messages.app.validator.number'))}}">
                            </div>
                        </div>
                        <div class="large-4 columns" id="surface">
                            <div class="comprar permutar">
                                <label for="surface">{{trans_choice('messages.words.surface',1)}}(m<sup>2</sup>)</label>
                                <input type="text" name="surface" id="surface" data-validate-func="number" data-validate-hint="{{trans(('messages.app.validator.number'))}}" value="{{$property->surface or ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="row bordered-top-bottom" id="commodities">
                        <div class="large-12 columns">
                            <label class="subtitulo">{{trans('messages.app.has.extras')}}</label>
                            @foreach($commodities as $extra)
                                <div class="option{{$extra->in_renta ? '' : ' comprar permutar'}}">
                                    <span><input type="checkbox" value="{{$extra->id}}" name="extra[]" @if(isset($property) && $property->commodities->pluck('id')->search($extra->id)) checked="checked" @endif></span>
                                    <span>{{trans('messages.db.extra.'.$extra->slugged)}}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
            <div id="pictures">
                <h1 class="title">{{trans_choice('messages.words.image',2)}}</h1>
                <h6 class="description">{{trans('messages.actions.images.description')}}</h6>
                @if(isset($property) && $property->images->count() > 0)
                    <div class="row">
                        <div class="large-12 columns">
                            <ul class="inline-list">
                                @foreach($property->images as $image)
                                    <li>
                                        <div class="image">
                                            <img src="{{asset('images/properties/'.$property->id.'/30/'.$image->localization)}}">
                                            <a class="delete" href="#" id="{{$image->id}}"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="large-12 columns">
                        <div class="upload">
                            <form id="dropzone-area" action="{{url('process/images')}}">
                                <h2 class="dz-message">{{trans('messages.app.dragAndDrop.area')}}</h2>
                                {!! csrf_field() !!}
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                            </form>
                            <div class="dz dropzone-previews" id="previews">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns" id="tos-agreement">
                        <input type="checkbox" name="tos" id="tos" value="1"/>
                        <span>{{trans('messages.app.accept.tos')}} <a href="{{\App\Helper::getPathFor('terminos'.($apk ? '/'.$apk : ''))}}">{{trans('messages.app.tos')}}</a></span>
                    </div>
                </div>
                <div class="row text-center controls">
                    <a href="#" class="next button background-green" id="back2">{{trans('messages.words.back')}}</a>
                    <a href="#" id="continue3" class="button background-ho">{{trans('messages.app.continue')}}</a>
                </div>
            </div>
            <div class="form-content" id="saving-window">
                <div class="row text-center">
                    <h1 class="title">{{trans('messages.actions.publish.saving')}}</h1>
                </div>
                <div class="row text-center saving">
                    <h5 class="description">{{trans('messages.actions.publish.saving.description')}}</h5>
                    <div class="spinner"><i class="fa fa-3x fa-spinner fa-pulse"></i></div>
                    <div id="#overlay">
                        <div class="loader">
                            {{trans('messages.app.saving.images.wait')}}
                        </div>
                    </div>
                </div>
                <div class="row text-center saved">
                    <h5 class="description">{{trans('messages.actions.publish.saved')}}</h5>
                    <a href="{{\App\Helper::getPathFor('user/dashboard')}}" class="button">{{trans('messages.words.start')}}</a>
                </div>
            </div>
        </div>
        <div class="row block-form hidden" id="choiceScreen">
            <div class="text-center">
                <h3 class="title">{{trans('messages.app.has.property.multiple')}}</h3>
                <h5 class="description">{{trans('messages.app.has.property.actual')}} <span class="actual"></span> {{trans('messages.words.from')}} <span class="total"></span></h5>
                <a class="button" id="next-property background-ho">{{trans('messages.app.has.property.next')}}</a>
                <a class="button" id="end-property background-blue">{{trans('messages.app.has.property.end')}}</a>
            </div>
        </div>
        <div class="row block-form hidden" id="savingPanel">
            <h4 class="title text-center" id="message">{{trans('messages.actions.publish.saving')}}</h4>
            <p id="spinner" class="text-center" style="color: #0FA0CE;"><i class="fa fa-refresh fa-spin fa-4x"></i></p>
        </div>
        <!--- Modal Warning Payment required -->
        @if(!Auth::user())
        <div id="myModal" class="reveal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <h3 id="modalTitle">Datos de la propiedad</h3>
        <hr>
        <p class="lead">Usted ha solicitado el plan <strong>{{$plan->label.' de '.$plan->price}} CUP</strong></p>
        <p>Luego de revisar su publicación lo llamaremos para pactar el pago.
            <span style="color: red">Su casa <strong>NO</strong> será visible hasta comprobado el pago.</span></p>
        <button class="button" id="accept-and-close">Continuar a la publicación</button>
        </div>
        @endif
        <!-------------------------------------->
    </div>
@endsection

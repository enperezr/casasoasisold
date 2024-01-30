@section('styles')
    <link rel="stylesheet" href="{{asset('css/forms.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/dropzone/css/basic.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/summernote/summernote-lite.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('vendor/dropzone/js/dropzone.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script src="{{asset('js/translator.js')}}"></script>
    <script src="{{asset('vendor/summernote/summernote-lite.js')}}"></script>
    <script src="{{asset('js/create-property.js')}}"></script>
    <script>
        $('.editor').summernote({
            height: 175,
            tabsize: 2,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'clear']],
                ['para', ['ul', 'ol']]
            ]
        });
    </script>
@endsection
@extends('layout.master')
@section('title', trans('messages.actions.publish'))
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('content')
    <div class="container">
        <div class="row block-form" >
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
                        <div class="medium-4 small-1 columns">
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
                                    <option value="{{$mun->id}}"@if(isset($property) && $mun->id == $property->municipio_id) selected="selected" @endif>{{$mun->name}}</option>
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
                                <label for="highness">{{trans('messages.words.highness')}}</label>
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
                                <label for="floors">{{trans_choice('messages.words.floor',2)}}</label>
                                <input type="text" id="floors" name="floors" value="{{$property->floors or ''}}" data-validate-func="number" data-validate-hint="{{trans(('messages.app.validator.number'))}}">
                            </div>
                        </div>
                        <div class="large-4 columns">
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
                                    <span><input type="checkbox" value="{{$extra->id}}" name="extra[]" @if(isset($property) && $property->commodities->contains('id',$extra->id)) checked="checked" @endif></span>
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
                        <div class="twelve columns">
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
                        <div class="twelve columns">
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
                    <div class="row text-center">
                        <a href="#" id="end" class="end button background-orange">{{trans('messages.app.save.everything')}}</a>
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
    </div>
@endsection
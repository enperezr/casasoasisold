@section('styles')
    <link rel="stylesheet" href="{{asset('vendor/jStarbox/css/jstarbox.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lightbox/css/lightbox.css')}}">
    <link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/forms.css')}}">
    <link rel="stylesheet" href="{{asset('css/reservation.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('vendor/jStarbox/jstarbox.js')}}"></script>
    <script src="{{asset('vendor/lightbox/js/lightbox.min.js')}}"></script>
    <script src="{{asset('vendor/jquery-ui/core.js')}}"></script>
    <script src="{{asset('vendor/jquery-ui/jquery.ui.datepicker-'.\Illuminate\Support\Facades\App::getLocale().'.js')}}"></script>
    <script src="{{asset('vendor/jquery-ui/datepicker.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script src="{{asset('js/reservation.js')}}"></script>
@endsection
@section('description', null !== $action->pivot->description ? $action->pivot->description : $property->getLabelName($action))
@section('keywords',$property->getKeyWordsForAction($action))
@extends('layout.master')
@section('title', trans('messages.words.reserve').' | '.$property->getLabelName($action))
@section('canonical')
    <link rel="canonical" href="{{Request::url()}}">
@endsection
@section('google')
    @include('portal.google-ads')
@endsection
@section('content')
    <div class="container">
        <div class="row" id="contact">
        <div class="twelve columns">
            <div class="row text-center name">
                <h4>{{$property->getLabelName($action)}}</h4>
                <a href="{{$property->getUrl($action)}}#main-content">{{trans('messages.app.see.details')}}</a>
            </div>
            <div class="row text-center">
                <ul class="inline-list" id="photo-list">
                    <?php $imgs = $property->images?>
                    @for($i = 0; ($i < 3 && $i < $imgs->count()); $i++)
                        <li class="img_{{$i}}">
                            <a href="{{asset('images/properties/'.$property->id.'/'.$imgs[$i]->localization)}}" data-lightbox="property-images" data-title="{{$imgs[$i]->description}}">
                                <img src="{{asset('images/properties/'.$property->id.'/50/'.$imgs[$i]->localization)}}" alt="{{$imgs[$i]->description}}"/>
                            </a>
                        </li>
                    @endfor
                    @for($i = 3; $i < count($imgs); $i++)
                        <li class="img_{{$i}}" style="display:none">
                            <a href="{{asset('images/properties/'.$property->id.'/'.$imgs[$i]->localization)}}" data-lightbox="property-images" data-title="{{$imgs[$i]->description}}"></a>
                        </li>
                    @endfor
                </ul>
            </div>
            <div class="row">
                <div class="eight columns offset-by-two">
                    <div class="main-form">
                        <h5 class="title">{{trans('messages.words.reserve')}}</h5>
                        <form action="/propiedad/reserva/{{$property->id}}" method="POST" id="form-information">
                        {{csrf_field()}}
                        <input name="property_id" type="hidden" value="{{$property->id}}">
                        <input name="action" type="hidden" value="{{$action->id}}">
                        <div class="row">
                            <div class="six columns">
                                <label for="fecha">{{trans('messages.app.arrival.date')}}<span class="obligatorio" title="{{trans('messages.app.validator.required')}}">*</span></label>
                                <input type="text" class="form-text u-full-width" id="fecha" name="arrival_date" data-validate-func="required" data-validate-hint="{{trans('messages.app.validator.required')}}">
                            </div>
                            <div class="three columns">
                                <label for="dias">{{trans_choice('messages.words.day', 2)}}<span class="obligatorio" title="{{trans('messages.app.validator.required')}}">*</span></label>
                                <input type="text" class="form-text u-full-width" id="dias" name="days" data-validate-func="number" data-validate-hint="{{trans('messages.app.validator.number')}}">
                            </div>
                            <div class="three columns">
                                <label for="personas">{{trans('messages.app.people.amount')}}<span class="obligatorio" title="{{trans('messages.app.validator.required')}}">*</span></label>
                                <input type="text" class="form-text u-full-width" id="personas" name="people" data-validate-func="number" data-validate-hint="{{trans('messages.app.validator.number')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="six columns">
                                <label>{{trans_choice('messages.words.name', 1)}}<span class="obligatorio" title="{{trans('messages.app.validator.required')}}">*</span></label>
                                <input type="text" class="form-text u-full-width" id="name" name="name" value="" data-validate-func="alpha" data-validate-hint="{{trans('messages.app.validator.letters')}}">
                            </div>
                            <div class="six columns">
                                <label>E-mail<span class="obligatorio" title="{{trans('messages.app.validator.required')}}">*</span></label>
                                <input type="text" class="form-text u-full-width" id="email" name="email" value="" data-validate-func="email" data-validate-hint="{{trans('messages.app.validator.email')}}" style="width: 100%">
                            </div>
                        </div>
                        <div class="row">
                            <div class="u-full-width">
                                <label>{{trans_choice('messages.words.comment',1)}}</label>
                                <textarea class="form-textarea u-full-width" rows="8" id="comment" name="comment"></textarea>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="twelve columns">
                                <input type="submit" class="button-primary form-submit" value="{{trans('messages.words.reserve')}}" id="form-contactar">
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="content"></div>
        </div>
    </div>
    </div>
@endsection
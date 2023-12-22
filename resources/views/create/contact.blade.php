@section('styles')
    <link rel="stylesheet" href="{{asset('css/forms.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('js/validator.js')}}"></script>
    <script src="{{asset('js/translator.js')}}"></script>
    <script src="{{asset('js/create-contact.js')}}"></script>

@endsection
@extends('layout.master')
@section('title', trans('messages.actions.publish'))
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('content')
    <div class="container">
        <div class="row block-form">
            <form class="formulario create" id="contact-form" method="post" action="{{\App\Helper::getPathFor('user/save-contact')}}">
                {!! csrf_field() !!}
                <input type="hidden" value="{{$contact ? $contact->id : ''}}" name="id"/>
                <div class="form-content" id="contact-info">
                    <h1 class="title">{{trans('messages.app.contact.data')}}</h1>
                    <h6 class="description">{{trans('messages.app.contact.data.description')}}</h6>
                    <div class="row">
                        <div class="medium-6 columns first">
                            <label for="names">{{trans_choice('messages.words.name',2)}}</label>
                            <input type="text" value="{{$contact ? $contact->names : ''}}" id="names" name="names" data-validate-func="required|alphaEnumerator" data-validate-hint="{{trans('messages.app.validator.letters.enumerator')}}">
                        </div>
                        <div class="medium-6 columns">
                            <label for="phones">{{trans_choice('messages.words.phone',2)}}</label>
                            <input type="text" value="{{$contact ? $contact->phones : ''}}" id="phones" name="phones" data-validate-func="required|digitsEnumerator" data-validate-hint="{{trans('messages.app.validator.digits.enumerator')}}">
                        </div>
                        <div class="medium-12 columns">
                            <label for="mail">{{trans_choice('messages.words.mail',1)}}</label>
                            <input type="text" value="{{$contact ? $contact->mail : ''}}" id="mail" name="mail" data-validate-func="email" data-validate-hint="{{trans('messages.app.validator.email')}}">
                        </div>
                        <div class="medium-3 columns">
                            <?php
                                if($contact->id)
                                    $hours = explode('-', $contact->hours);
                            ?>
                            <label>{{trans_choice('messages.words.hour',1)}}</label>
                            <select id="since-hour" name="since-hour">
                                <option value="8" {{isset($hours) ? ($hours[0] == '8' ? 'selected' : '') : ''}}>8am</option>
                                <option value="10" {{isset($hours) ? ($hours[0] == '10' ? 'selected' : '') : ''}}>10am</option>
                                <option value="12" {{isset($hours) ? ($hours[0] == '12' ? 'selected' : '') : ''}}>12m</option>
                                <option value="15" {{isset($hours) ? ($hours[0] == '15' ? 'selected' : '') : ''}}>3pm</option>
                                <option value="17" {{isset($hours) ? ($hours[0] == '17' ? 'selected' : '') : ''}}>5pm</option>
                                <option value="20" {{isset($hours) ? ($hours[0] == '20' ? 'selected' : '') : ''}}>8pm</option>
                            </select>
                        </div>
                        <div class="medium-3 columns">
                            <label>&nbsp;</label>
                            <select id="until-hour" name="until-hour">
                                <option value="17" {{isset($hours) ? ($hours[1] == '17' ? 'selected' : '') : ''}}>5pm</option>
                                <option value="12" {{isset($hours) ? ($hours[1] == '12' ? 'selected' : '') : ''}}>12m</option>
                                <option value="20" {{isset($hours) ? ($hours[1] == '20' ? 'selected' : '') : ''}}>8pm</option>
                                <option value="21" {{isset($hours) ? ($hours[1] == '21' ? 'selected' : '') : ''}}>11pm</option>
                            </select>
                        </div>
                        <div class="medium-3 columns">
                            <?php
                            if($contact->id)
                                $days = explode('-', $contact->days);
                            ?>
                            <label>{{trans_choice('messages.words.day',2)}}</label>
                            <div style="width: 100%">
                                <select id="since" name="since">
                                    @for($i = 0; $i < 7; $i++)
                                        <option value="{{$i}}" {{isset($days) ? ($days[0] == $i ? 'selected' : '') :( $i == 1 ? 'selected' : '')}}>{{trans('formats.week.day.'.$i)}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="medium-3 columns">
                            <label>&nbsp;</label>
                            <select id="until" name="until">
                                @for($i = 0; $i < 7; $i++)
                                    <option value="{{$i}}" {{isset($days) ? ($days[1] == $i ? 'selected' : '') : ($i == 6 ? 'selected' : '')}}>{{trans('formats.week.day.'.$i)}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="row text-center">
                        <a href="#" class="next button background-blue" id="submit">{{trans('messages.app.save.everything')}}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
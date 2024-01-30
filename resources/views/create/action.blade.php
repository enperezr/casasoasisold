@section('styles')
    <link rel="stylesheet" href="{{asset('css/forms.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('js/validator.js')}}"></script>
    <script src="{{asset('js/translator.js')}}"></script>
    <script src="{{asset('js/create-action.js')}}"></script>

@endsection
@extends('layout.master')
@section('title', trans('messages.actions.publish'))
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('content')
    <div class="container">
        <div class="row block-form" >
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
                                @foreach($types as $type)
                                    @if($type->id < 3)
                                        <option value="{{$type->id}}" {{$action->action ? ($action->action->id == $type->id ? 'selected' : '') : ''}}>{{trans('messages.db.action.'.$type->slugged)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="medium-4 columns ventas rentas">
                            <label for="price">{{trans_choice('messages.words.price', 1)}}</label>
                            <input type="text" value="{{$action ? $action->price : ''}}" name="price" id="price">
                        </div>
                        <div class="medium-4 columns permutas" style="display: none">
                            <label for="option">{{trans_choice('messages.words.option', 1)}}</label>
                            <select name="option" id="option">
                                <option value="1x1" {{$action ? ($action->condition=='1x1' ? 'selected' : '') : ''}}>1x1</option>
                                <option value="1x2" {{$action ? ($action->condition=='1x2' ? 'selected' : '') : ''}}>1x2</option>
                                <option value="1x3" {{$action ? ($action->condition=='1x3' ? 'selected' : '') : ''}}>1x3</option>
                                <option value="2x1" {{$action ? ($action->condition=='2x1' ? 'selected' : '') : ''}}>2x1</option>
                                <option value="3x1" {{$action ? ($action->condition=='3x1' ? 'selected' : '') : ''}}>3x1</option>
                                <option value="3x2" {{$action ? ($action->condition=='3x2' ? 'selected' : '') : ''}}>3x2</option>
                                <option value="2x3" {{$action ? ($action->condition=='2x3' ? 'selected' : '') : ''}}>2x3</option>
                            </select>
                        </div>
                        <div class="large-12 columns">
                            <label for="description">{{trans('messages.words.description')}}</label>
                            <textarea name="description" id="description">{{$action ? $action->description : ''}}</textarea>
                        </div>
                        <div class="large-6 columns ventas permutas">
                            <label for="concluded">{{trans('messages.app.action.concluded')}}</label>
                            <select name="concluded" id="concluded">
                                <option value="0" {{$action->concluded == 0 ? 'selected' : ''}}>{{trans('messages.words.no')}}</option>
                                <option value="1" {{$action->concluded == 1 ? 'selected' : ''}}>{{trans('messages.words.yes')}}</option>
                            </select>
                        </div>
                        <div class="large-12 columns text-center">
                            <a href="#" id="end" class="end button background-orange">{{trans('messages.app.save.everything')}}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
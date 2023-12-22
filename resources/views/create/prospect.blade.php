@section('styles')
    <link rel="stylesheet" href="{{asset('css/forms.css')}}">
    <link rel="stylesheet" href="{{asset('css/guide.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('js/validator.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            var form = $('form');
            form.validator({acceptEmpty:false});
            $('button').click(function(e){
                e.preventDefault();
                if(form.validate()){
                    form.submit();
                }
            });
        });

    </script>
@endsection
@extends('layout.master')
@section('title', trans('messages.actions.publish.title'))
@section('description', trans('messages.app.publish.description'))
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('google')
    @include('portal.google-ads')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="large-6 columns large-push-3 form-container">
                <h3>{{trans('messages.app.require_contact_data')}}</h3>
                <form action="{{\App\Helper::getPathFor('prospect/save')}}" method="post">
                    {{csrf_field()}}
                    <div class="form">
                        <label for="plan">Plan</label>
                        <select name="plan" id="plan">
                            @foreach($plans as $p)
                                <option value="{{$p->id}}" @if($p->id == $plan->id) selected="selected" @endif>{{($p->days > 2 * 365 ? trans('messages.app.no.time.limit') : intval($p->days/30).' '.trans_choice('formats.month',2)).' x '.$p->price.' CUC'}}</option>
                            @endforeach
                        </select>
                        <label for="name">{{trans_choice('messages.words.name', 1)}} <sup class="req">*</sup></label>
                        <input type="text" id="name" name="names" maxlength="40" data-validate-func="required|alphaEnumerator" data-validate-hint="{{trans('messages.app.validator.letters.enumerator')}}">
                        <label for="phone">{{trans_choice('messages.words.phone', 1)}} <sup class="req">*</sup></label>
                        <input type="text" id="phone" name="phones" maxlength="40" data-validate-func="required|digitsEnumerator" data-validate-hint="{{trans('messages.app.validator.digits.enumerator')}}">
                        <label for="client_message">{{trans('messages.words.message')}}</label>
                        <textarea id="client_message" name="client_messages" rows="4"></textarea>
                        <div class="text-center">
                            <button type="submit" class="button">{{trans('messages.words.send')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
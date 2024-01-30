@extends('layout.admin')
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('title', 'Finanzas')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection
@section('content')
    <div class="container full">
        <div class="row block-form">
            <form action="{{\App\Helper::getPathFor('admin/finances/calculate')}}" method="post">
                {{csrf_field()}}
                <div class="large-12 columns">
                    <div class="menu">
                        <h2>Finances</h2>
                    </div>
                </div>
                <div class="large-5 columns ">
                    <label for="from">From Date</label>
                    <input id="from" name="from" type="date" value="{{$from or ''}}">
                </div>
                <div class="large-5 columns">
                    <label for="to">To Date</label>
                    <input id="to" name="to" type="date" value="{{$to or ''}}">
                </div>
                <div class="large-2 columns">
                    <label>&nbsp;</label>
                    <button class="button button-primary">Calcular</button>
                </div>
            </form>
        </div>
        <div class="row collapse">
            <div class="large-12 columns">
                <table class="regular" id="admin_finances">
                <thead>
                <tr>
                    <td>Id</td>
                    <td>Registerer</td>
                    <td>Provider</td>
                    <td>Type</td>
                    <td>Plan</td>
                    <td>Real</td>
                    <td>Via</td>
                    <td>Property</td>
                    <td>Created</td>
                </tr>
                </thead>
                <tbody>
                @foreach($registers as $register)
                    <tr>
                        <td>{{$register->id}}</td>
                        <td>{{$register->registerer_relation->name}}({{$register->registerer_relation->rol->name}})</td>
                        <td>@if($register->provider_relation){{$register->provider_relation->name}}({{$register->provider_relation->rol->name}})@endif</td>
                        <td>{{$register->type}}</td>
                        <td>{{$register->plan->days}} days</td>
                        <td>@if($register->real_m) 
                        <span class="note">{!! $register->real_m !!} <i class="fa fa-comment" data-note="{{$register->note}}"></i></span>
                            @else 
                            {!! $register->plan->price !!}
                            @endif
                        </td>
                        <td>
                            {!! $register->payment_via!!}
                        </td>
                        <td>@if($register->property)<a href="{{$register->property->getUrl()}}" target="_blank">{{$register->property->id}}</a>@else DELETED @endif</td>
                        <td>{{$register->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="row block-form">
            <form action="{{\App\Helper::getPathFor('admin/finances/calculate')}}" method="post">
                {{csrf_field()}}
                <div class="large-12 columns">
                    <div class="menu">
                        <h2>RESUME</h2>
                    </div>
                </div>
            </form>
        </div>
        <div class="row collapse">
            <div class="large-12 columns">
                <table class="regular" id="admin_finances_resume">
                    <thead>
                    <tr>
                        <td>Provider</td>
                        <td>New Properties</td>
                        <td>Renew Properties</td>
                        <td>Total</td>
                        <td>Commissions</td>
                        <td>Net</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($resumeAndTotal['resume'] as $resume)
                        <tr>
                            <td>{{$resume['provider']->name}}({{$resume['provider']->rol->name}})</td>
                            <td>
                                @if(isset($resume['new']))
                                    @foreach($resume['new'] as $plan_id=>$q)
                                        <?php $plan = \App\Plan::find($plan_id)?>
                                        {{$q.' - '.$plan->price.' CUC, '}}
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if(isset($resume['renew']))
                                    @foreach($resume['renew'] as $plan_id=>$q)
                                        <?php $plan = \App\Plan::find($plan_id)?>
                                        {{$q.' - '.$plan->price.' CUC, '}}
                                    @endforeach
                                @endif
                            </td>
                            <td>{{$resume['total']}}</td>
                            <td>{{$resume['commissions']}}</td>
                            <td>{{$resume['net']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Totals</td>
                            <td>
                                @foreach($resumeAndTotal['totals']['new'] as $plan_id=>$q)
                                    <?php $plan = \App\Plan::find($plan_id)?>
                                    {{$q.' - '.$plan->price.' CUC, '}}
                                @endforeach
                            </td>
                            <td>
                                @foreach($resumeAndTotal['totals']['renew'] as $plan_id=>$q)
                                    <?php $plan = \App\Plan::find($plan_id)?>
                                    {{$q.' - '.$plan->price.' CUC, '}}
                                @endforeach
                            </td>
                            <td>
                                {{$resumeAndTotal['totals']['total']}} CUC
                            </td>
                            <td>
                                {{$resumeAndTotal['totals']['commissions']}} CUC
                            </td>
                            <td>
                                {{$resumeAndTotal['totals']['net']}} CUC
                            </td>
                        </tr>


                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row collapse">
            <div class="large-12 columns">
                <ul style="display:inline-block; list-style: none;">
                    @foreach($resumeAndTotal['payments'] as $via=>$total)
                    <li style="border:1px solid; padding:10px">{{$via}} - {{$total}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
<script type="text/javascript">
    $(function(){
        $('body').on('click', '#admin_finances .note i', function(e){
                alert($(e.target).data('note'));
            });
    });
</script>
@endsection
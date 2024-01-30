@section('styles')
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('js/admin.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            var modal = $('#stateModal');
            $('a.attention').click(function(e){
                e.preventDefault();
                var state = $(this).parents('tr').data('state');
                var reason = $(this).parents('tr').data('reason');
                var id = $(this).parents('tr').data('id');
                modal.find('#state').val(state);
                modal.find('#reason').val(reason);
                modal.find('#id').text(id);
                modal.foundation('open');
            });
            $('button#submit').click(function(e){
                var state = modal.find('#state').val();
                var reason = modal.find('#reason').val();
                var id = modal.find('#id').text();
                $.post('{{\App\Helper::getPathFor('prospect/update')}}', {id:id, state:state, reason:reason}, function(data){
                    if(data){
                        window.location.href = window.location.href;
                    }

                }).fail(function(xhr){
                    alert(xhr.statusText);
                });
            });
        });
    </script>
@endsection
@extends('layout.admin')
@section('title', 'Admin Interface')
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('content')
    <div class="container">
        <div class="row block-form">
            <div class="medium-12 columns">
                <h3>Latest Prospects</h3>
                <a href="/rebuild/sitemap">Regenerar sitemap</a>
                <?php
                    $states = [0=>'Sin Atender', 1=>'Atendido', 2=>'Aceptado', 3=>'Declinado'];
                ?>
                <table class="table regular" id="prospects_table">
                    <thead>
                    <tr>
                        <td>Id</td>
                        <td>Fecha</td>
                        <td>Names</td>
                        <td>Phones</td>
                        <td>Plan</td>
                        <td>Message</td>
                        <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($prospects as $prospect)
                        <tr class="@if($prospect->processed == 0) bold @endif" data-state="{{$prospect->processed}}" data-reason="{{$prospect->reason}}" data-id="{{$prospect->id}}">
                            <td>{{$prospect->id}}</td>
                            <td>{{$prospect->created_at}}</td>
                            <td>{{$prospect->name}}</td>
                            <td>{{$prospect->phone}}</td>
                            <td>{{$prospect->plan->price}} CUC</td>
                            <td>{{$prospect->message}}</td>
                            <td>
                                <a class="attention">{{$states[$prospect->processed]}}</a>
                                <p>{{$prospect->reason}}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="reveal" id="stateModal" data-reveal>
        <h2>Update State for Prospect <span id="id"></span></h2>
        <label for="state">New State</label>
        <select id="state" name="state">
            @foreach($states as $key=>$state)
            <option value="{{$key}}">{{$state}}</option>
            @endforeach
        </select>
        <label for="reason">Reason</label>
        <textarea id="reason" name="reason"></textarea>
        <div class="controls text-right">
            <button class="button" id="submit">Save</button>
        </div>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endsection
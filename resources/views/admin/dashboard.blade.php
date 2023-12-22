@section('styles')
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('js/admin.js')}}"></script>
@endsection
@extends('layout.admin')
@section('title', 'Admin Interface')
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('content')
    <div class="container">
        <div class="row block-form" >
            <form action="{{\App\Helper::getPathFor('admin/dashboard')}}" method="post">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="medium-10 columns">
                        <label for="query">QUERY</label>
                        <input type="text" name="query" id="query" value="{{$query or ''}}">
                    </div>
                    <div class="medium-2 columns">
                        <input type="submit" value="SEARCH" class="button search">
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
        @if(isset($result) && $result->count())
            <table class="as_admin" id="results">
                <tr class="text-left">
                    <th>Contact Name</th>
                    <th>Operation</th>
                    <th>Last Updated Time</th>
                    <th>Time Reserved</th>
                    <th>Days Remaining</th>
                    <th>Closed</th>
                </tr>
            @foreach($result as $r)
                <tr id="{{$r->id}}" class="result">
                    <td><h6>{{$r->contact->names}}</h6></td>
                    <td>{{$r->action->name}}</td>
                    <td class="date">{{$r->created_at}}</td>
                    <td><input value="{{$r->time}}" class="time" readonly="readonly" data-value="{{$r->time}}"/></td>
                    <td class="remaining">
                        <?php $daysPassed = \Carbon\Carbon::today()->diffInDays($r->created_at);?>
                        {{$r->time - $daysPassed}}
                    </td>
                    <td>
                        <select class="concluded">
                            <option @if($r->concluded) selected="selected" @endif value="1">YES</option>
                            <option @if(!$r->concluded) selected="selected" @endif value="0">NO</option>
                        </select>
                    </td>
                </tr>
            @endforeach
            </table>
        @else
            @if(isset($query))
                <h6>No Results Found for query <span class="highlight">"{{$query}}"</span></h6>
            @endif
        @endif
        </div>
        <div class="row text-center">
            <span id="loader"><i class="fa fa-spin fa-4x fa-yelp"></i></span>
        </div>
        <div class="row" id="related">

        </div>
    </div>
@endsection
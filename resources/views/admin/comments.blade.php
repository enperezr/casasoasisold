@section('styles')
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/datatables/css/dataTables.foundation.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/reviewadmin.js')}}"></script>
@endsection
@extends('layout.admin')
@section('title', 'Admin Interface')
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('content')
    <div class="container">
        <div class="row block-form">
            <div class="large-12">
                <h1>Comments</h1>
                <table class="data data_local">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Property</th>
                            <th>User</th>
                            <th>E-mail</th>
                            <th>name</th>
                            <th>text</th>
                            <th>Created</th>
                            <th>Modified</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                            <tr>
                                <td>{{$comment->properties_action_id}}</td>
                                <td>{{$comment->property_id}}</td>
                                <td>{{$comment->user_id}}</td>
                                <td>{{$comment->email}}</td>
                                <td>{{$comment->name}}</td>
                                <td>{{$comment->text}}</td>
                                <td>{{\App\Helper::timeStamptToFormat($comment->created_at, '%Y/%m/%d')}}</td>
                                <td>{{\App\Helper::timeStamptToFormat($comment->updated_at, '%Y/%m/%d')}}</td>
                                <td>
                                    <a class="command"><i class="fa fa-send"></i></a>
                                    <a class="command"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
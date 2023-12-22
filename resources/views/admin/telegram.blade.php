@extends('layout.admin')
@section('title', 'Admin Interface')
@section('content')
    <div class="container full">
        <div class="row">
            <h1 class="float-left">Telegram Logs</h1>
        </div>
        <div class="row block-form collapse">
            <div class="large-12 columns">
                <table id="admin_properties">
                    <thead>
                        <tr>
                            <td class="text-center" width="100">Query</td>
                            <td>Response</td>
                            <td>date</td>
                            <td width="120">action</td>
                        </tr>
                    </thead>
                    <body>
                        @foreach($logs as $log)
                        <?php
                            $entity = json_decode($log->content);
                            if(property_exists($entity, 'message'))
                                $message = $entity->message;
                            else if(property_exists($entity, 'edited_message'))
                                $message = $entity->edited_message;
                            else if(property_exists($entity, 'channel_post'))
                                $message = $entity->channel_post;
                            
                        ?>
                            <tr>
                                <td>{{$message->text}}</td>
                                <td>{{$log->response}}</td>
                                <td>{{$log->created_at}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="row">
        {!! $logs->render() !!}
        </div>
        
    </div>
@endsection
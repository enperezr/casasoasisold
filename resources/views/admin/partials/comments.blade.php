<div class="row comments_container">
    <div class="medium-12 columns">
        @if($comments->count()>0)
            <h3>Comments for property {{$property_id}}</h3>
            <table class="data data_local">
                <thead>
                <tr>
                    <th>E-mail</th>
                    <th>name</th>
                    <th width="50%">text</th>
                    <th>Created</th>
                    <th>Modified</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                    <tr data-id="{{$comment->id}}">
                        <td>{{$comment->email}}</td>
                        <td>{{$comment->name}}</td>
                        <td>{{$comment->text}}</td>
                        <td>{{\App\Helper::timeStamptToFormat($comment->created_at, '%Y/%m/%d')}}</td>
                        <td>{{\App\Helper::timeStamptToFormat($comment->updated_at, '%Y/%m/%d')}}</td>
                        <td>
                            <a class="command publish"><i class="fa {{$comment->published ? 'fa-check-square-o':'fa-square-o'}}"></i></a>
                            <a class="command delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h3>No Comments for property {{$property_id}}</h3>
        @endif
    </div>
</div>
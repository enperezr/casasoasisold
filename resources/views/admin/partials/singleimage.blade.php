<li class="image {{$image->front ? 'front' : ''}}" data-id="{{$image->id}}">
    <img alt="{{$image->description}}" src="{{asset('images/properties/'.$property_id.'/30/'.$image->localization)}}" data-description="{{$image->description}}">
    <span class="edit">
        <a class="set_front"><i class="fa fa-puzzle-piece"></i></a>
        <a class="edit_image"><i class="fa fa-edit"></i></a>
        <a class="delete_image"><i class="fa fa-trash"></i></a>
    </span>
    <div class="edition" style="display: none">
        <textarea name="description" class="image-description" data-description="{{$image->description}}">{{$image->description}}</textarea>
        <span><button class="button read-more ok">ok</button><button class="button cancel">cancel</button></span>
    </div>
</li>
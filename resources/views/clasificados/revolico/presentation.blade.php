<div class="row revo_container">
    <div class="medium-12 columns">
        <h3>Announce configuration in revolico for property {{$property->id}}</h3>
    </div>
    <form id="announce">
    <div class="row">
        <div class="medium-3 columns">
            <label for="price">Price</label>
            <input type="text" name="price" id="price" value="{{$action->price}}">
        </div>
        <div class="medium-9 columns">
            <label for="title">Title</label>
            <?php
            $str = $property->baths;
            $str.=' ba&ntilde;o';
            if($property->baths != 1)
                $str.='s';
            $str.=' '.$property->rooms.' dorm';
            ?>
            <input type="text" name="title" id="title" value="???{{$property->getLabelName($action->action).' '.$str.' '.$action->contact->phones}}">
        </div>
    </div>
    <div class="row">
        <div class="medium-12 columns">
            <label for="content">Content</label>
            <textarea name="content" id="content" rows="10">@include('clasificados.revolico.body', ['property'=>$property, 'action'=>$action])</textarea>
        </div>
    </div>
    <div class="row">
        <div class="medium-6 columns">
            <label for="names">Names</label>
            <input type="text" name="names" id="names" value="{{$action->contact->names}}">
        </div>
        <div class="medium-6 columns">
            <label for="phones">Phones</label>
            <input type="text" name="phones" id="phones" value="{{$action->contact->phones}}">
        </div>
    </div>
    <div class="row">
        <div class="medium-12 columns">
            <ul class="inline-list" id="pictures">
            @foreach($property->images as $image)
                <li data-src="{{$image->localization}}">
                    <img alt="{{$image->description}}" src="{{asset('images/properties/'.$property->id.'/30/'.$image->localization)}}">
                </li>
            @endforeach
            </ul>
        </div>
    </div>
    <input type="hidden" name="images" id="form_pictures">
    <input type="hidden" name="pid" value="{{$property->id}}">
    </form>
    <div class="controls row">
        <center>
            @if(str_contains($property->promocioned, 'rev'))
                <strong>This announce has already been sended, make sure to delete it in revorobot to avoid duplicates</strong>
            @endif
            <button class="button primary" id="send_announce">Enviar</button>
        </center>
    </div>
</div>
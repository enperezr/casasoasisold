<article class="property-long user-property" data-id="{{$property->id}}">
    <div class="id-data display-inline">
        <h3>{{$property->id}}</h3>
    </div>
    <div class="picture display-inline">
        @if($property->getMainPicture())
          <figure>
            <img src="{{asset('images/properties/'.$property->id.'/30/'.$property->getMainPicture()->localization)}}" alt="{{$property->name}}"/>
          </figure>
        @else
            <img src="{{asset('images/properties/default/30/avatar_casa.png')}}" alt="{{$property->name}}"/>
        @endif
    </div>
    <div class="details display-inline">
        <span class="name show-for-medium">
            @if($property->name != '')
                {{$property->name}}
            @else
                {{$property->address}}
            @endif
        </span>
        <div class="entry-features">
                @if($property->rooms > 0)
                    <span class="rooms">
                {{$property->rooms}}
                        <i>
                            <object data="{{asset('images/icons/cama-negra.svg')}}" height="16" width="22" type="image/png">
                                <img src="{{asset('images/icons/cama-negra.png')}}">
                            </object>
                        </i>
            </span>
                @endif
                @if($property->baths > 0)
                    <span class="baths">
                    {{$property->baths}}
                        <i style="padding-top: .5em">
                            <object data="{{asset('images/icons/bano-negro.svg')}}" height="16" width="22" type="image/png">
                                <img src="{{asset('images/icons/bano-negro.png')}}">
                            </object>
                        </i>
                </span>
                @endif
                @if($property->surface > 0)
                    <span class="size">
                <i class="fa fa-expand"></i>
                        {{$property->surface}} m<sup>2</sup>
            </span>
                @endif
            </div>
        <figure class="more-pictures">
            <div class="picture-list">
                @foreach($property->images as $image)
                    <img src="{{asset('images/properties/'.$property->id.'/30/'.$image->localization)}}"/>
                @endforeach
            </div>
        </figure>
    </div>
    <div class="actions display-inline float-right">
        <a href="{{\App\Helper::getPathFor('user/modify/property/'.$property->id)}}" class="edit-property">
            <i class="fa fa-edit"></i>
        </a>
        <a href="#" class="delete">
            <i class="fa fa-trash"></i>
        </a>
    </div>
</article>

<div class="row image_container">
    <div class="medium-12 columns">
        <h3>Images from property {{$property_id}}</h3>
    </div>
    <div class="large-9 columns">
        <ul id="images">
            @foreach($images as $image)
                @include('admin.partials.singleimage',['property_id'=>$property_id, 'image'=>$image])
            @endforeach
        </ul>
    </div>
    <div class="large-2 columns">
        <div id="dropzone">
            <div class="upload">
                <form id="dropzone-area" action="{{url('process/images')}}">
                    <h6 class="dz-message">{{trans('messages.app.dragAndDrop.area')}}</h6>
                    {!! csrf_field() !!}
                    <div class="fallback">
                        <input name="file" type="file" multiple/>
                    </div>
                </form>
                <div class="dz dropzone-previews" id="previews">
                </div>
            </div>
        </div>
    </div>
</div>
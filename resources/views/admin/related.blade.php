<div class="row">
    @include('shared.userContact', ['contact'=>$contact])
    @foreach($properties as $property)
        @include('shared.userProperty',['property'=>$property])
    @endforeach
</div>
@if($ads && array_filter($ads, function($item)use($place){return str_contains($item->places, $place);}))
<div class="row" style="margin-bottom: 10px">
    <div class="large-12 columns no-padding">
        <div class="orbit" role="region" data-orbit aria-label="advertisement from partners">
            <ul class="orbit-container">
                @foreach($ads as $ad)
                    @if(str_contains($ad->places, $place))
                    <li class="orbit-slide">
        
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif
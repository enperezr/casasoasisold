<div class="row" id="propertiesList_title">

</div>
<div class="row" id="loader">
    <div id="progress">
        <div id="new">
            <span><i class="fa fa-refresh fa-spin"></i>{{trans('messages.words.loading')}}</span>
        </div>
    </div>
</div>
<div class="row">
    <div id="presentation-controls">
                        <span id="count" class="float-left">
                            Total: <span class="bold">{{$search->total()}}</span>
                        </span>
        <div id="orders" class="float-right">
            <div class="control">
                <select id="order" name="order" class="form-select minimal">
                    <option value="recent" {!! $order == 'recent' ? 'selected=selected' : '' !!}>{{trans('messages.words.newest')}}</option>
                    <option value="oldest" {!! $order == 'oldest' ? 'selected=selected' : '' !!}>{{trans('messages.words.oldest')}}</option>
                    <option value="expensive" {!! $order == 'expensive' ? 'selected=selected' : '' !!} class="ventas">{{trans('messages.words.most.adj',['adj'=>trans('messages.words.expensive')])}}</option>
                    <option value="cheap" {!! $order == 'cheap' ? 'selected=selected' : '' !!} class="ventas">{{trans('messages.words.sheapest')}}</option>
                    <option value="small" {!! $order == 'small' ? 'selected=selected' : '' !!}>{{trans('messages.words.smallest')}}</option>
                    <option value="big" {!! $order == 'big' ? 'selected=selected' : '' !!}>{{trans('messages.words.biggest')}}</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
@if($search->total() != 0)
    @foreach($search->items() as $result)
        <?php $pactions = $result->getThisAction($action)?>
        @foreach($pactions as $paction)
            @include('shared.property-long',['property'=>$result, 'action'=>$paction])
        @endforeach
    @endforeach
@else
    <h6 class="text-center margin-top-10">{{trans('messages.app.not.results')}}</h6>
@endif
<div class="row" id="pagination">
    <?php echo $search->render()?>
</div>
<script>
    document.getElementById('propertiesList_title').innerHTML = '<h1>'+document.title+'</h1>';
</script>

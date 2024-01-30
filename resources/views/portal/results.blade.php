<div class="large-9 columns">
    <div class="row">
        <div id="presentation-controls">
            <div id="orders" class="float-right">
                <div class="control">
                    <select id="order" name="order" class="form-select minimal">
                        <option value="recent" {!! $order == 'recent' ? 'selected=selected' : '' !!}>{{ trans('messages.words.newest') }}</option>
                        <option value="oldest" {!! $order == 'oldest' ? 'selected=selected' : '' !!}>{{ trans('messages.words.oldest') }}</option>
                        <option value="expensive" {!! $order == 'expensive' ? 'selected=selected' : '' !!}>
                            {{ trans('messages.words.most.adj', ['adj' => trans('messages.words.expensive')]) }}</option>
                        <option value="cheap" {!! $order == 'cheap' ? 'selected=selected' : '' !!}>{{ trans('messages.words.sheapest') }}</option>
                        <option value="small" {!! $order == 'small' ? 'selected=selected' : '' !!}>{{ trans('messages.words.smallest') }}</option>
                        <option value="big" {!! $order == 'big' ? 'selected=selected' : '' !!}>{{ trans('messages.words.biggest') }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    @foreach ($search as $result)
        <?php $pactions = $result->getThisAction($taction); ?>
        @foreach ($pactions as $paction)
            @include('shared.property-long', ['property' => $result, 'action' => $paction])
        @endforeach
    @endforeach
</div>


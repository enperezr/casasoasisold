<div class="row contacts_container">
    <div class="large-12 columns">
        <h3>Actions For Property {{ $property->id }}</h3>
        @foreach ($actions as $action)
            <div class="row action">
                <div class="large-12 columns">
                    <form>
                        <input type="hidden" name="id" value="{{ $action->id }}" id="id_action">
                        <span class="badget {{ $action->action_id == 2 ? 'permuta' : 'venta' }}"
                            data-id="{{ $action->id }}">
                            {{ $action->action_id == 2 ? 'PERMUTA' : 'VENTA' }}
                        </span>
                        <span>
                            <i class="fa fa-arrow-right"></i>
                        </span>
                        <span class="price_condition" width="100px">
                            <input type="text" name="price_condition"
                                value="{{ $action->action_id == 2 ? $action->condition : $action->price }}"
                                class="price_condition">
                        </span>
                        @if ($action->action_id != 2)
                            <span class="currency">
                                <select name='currency' id="currency">
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ $currency->id == $action->currency_id ? 'selected=selected' : '' }}>
                                            {{ $currency->slugged }} </option>
                                    @endforeach
                                </select>
                            </span>
                        @endif
                        <span class="action controls">
                            <a href="#" class="button change"><i class="fa fa-retweet"></i></a>
                            @if (count($actions) > 1)
                                <a href="#" class="button delete" data-property="{{ $property->id }}"
                                    data-action="{{ $action->id }}"><i class="fa fa-trash"></i></a>
                            @endif
                        </span>
                        <textarea name="description">{{ $action->description }}</textarea>
                        <span class="command_line"><button class="button read-more save">SAVE</button></span>
                    </form>
                    <hr>
                </div>
            </div>
        @endforeach
        @if (count($actions) == 1)
            <div class="row action">
                <div class="large-12 columns">
                    <form>
                        @if ($actions[0]->action_id == 2)
                            <span class="badget venta">VENTA</span>
                            <input type="hidden" name="action" value="1" />
                        @else
                            <span class="badget permuta">PERMUTA</span>
                            <input type="hidden" name="action" value="2" />
                        @endif
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                        <span>
                            <i class="fa fa-arrow-right"></i>
                        </span>
                        <span class="price_condition">
                            <input type="text" name="price_condition" value="">
                        </span>
                        <textarea name="description"></textarea>
                        <span class="command_line"><a href="#" class="button read-more new">ADD NEW ACTION</a></span>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

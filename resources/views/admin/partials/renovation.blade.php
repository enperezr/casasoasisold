<div class="row contacts_container">
    <div class="large-12 columns">
        <h3>@if($property->plan_id != 0) Renew Plan @else Set Plan @endif For Property {{$property->id}}</h3>
        <div class="row text-center">
            <?php $daysPassed = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property->date));?>
            <h4 class="calculate">{{$property->actions[0]->time - $daysPassed <= 0 ? 0 : $property->actions[0]->time - $daysPassed}} from {{$property->actions[0]->time}}</h4>
            <p class="base_date">{{\App\Helper::timeStamptToFormat($property->date, '%Y/%m/%d')}}</p>
            <div class="row action_days text-left">
                <div class="large-4 columns">
                    <label for="plan">Plan</label>
                    <select name="plan" id="plan">
                        @foreach($plans as $plan)
                            <option value="{{$plan->id}}">{{$plan->days}} Days x {{$plan->price}} CUC</option>
                        @endforeach
                    </select>
                </div>
                <div class="large-4 columns">
                    <label for="provider">Provider</label>
                    <select name="provider" id="provider">
                        <option value="">No</option>
                        @foreach($providers as $provider)
                            <option value="{{$provider->id}}" @if($provider->id == $property->provider_id) selected="selected" @endif>{{$provider->name}}({{$provider->rol->name}})</option>
                        @endforeach
                    </select>
                </div>
                <div class="large-4 columns">
                    <label for="payment">Via de Pago</label>
                    <select name="payment" id="payment">
                        <option value="trf">Transferencia</option>
                        <option value="paypal">Paypal</option>
                        <option value="saldo">Saldo</option>
                        <option value="efectivo">Efectivo</option>
                    </select>
                </div>
                <div class="large-12 columns">
                    <label for="note">Nota(Alguna aclaración necesaria)</label>
                    <textarea name="note" id="note" rows="3"></textarea>
                </div>
                <div class="large-12 columns text-center">
                    <label for="real">Real, Normalmente este campo debe quedarse vacío, existe para los casos muy especiales,
                        y no debe llenarse si no esta acompañado por el campo nota anterior.
                    </label>
                    <input type=text name=real id="real" class="control" style="width: 200px; display:inline-block"/>
                </div>
                <div class="large-12 columns text-center">
                    <button class="button success renovate">RENOVATE</button>
                </div>
            </div>
        </div>
    </div>
</div>
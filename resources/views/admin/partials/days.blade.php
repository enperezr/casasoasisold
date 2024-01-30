<div class="row contacts_container">
    <div class="large-12 columns">
        <h3>Days For Property {{$property->id}}</h3>
        <div class="row text-center">
            <?php $daysPassed = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property->date));?>
            <h4 class="calculate">{{$property->actions[0]->time - $daysPassed <= 0 ? 0 : $property->actions[0]->time - $daysPassed}} from {{$property->actions[0]->time}}</h4>
            <p class="base_date">{{\App\Helper::timeStamptToFormat($property->date, '%Y/%m/%d')}}</p>
                <hr/>
            <div class="action_days">
                <div class="input-group">
                    <span class="input-group-label">ADD DAYS</span>
                    <input class="input-group-field" type="number" id="days" title="days">
                    <div class="input-group-button">
                        <input type="submit" class="button add" value="ADD">
                    </div>
                </div>
                <span>OR </span><button class="button read-more reset">RESET DAYS</button>
            </div>
        </div>
    </div>
</div>
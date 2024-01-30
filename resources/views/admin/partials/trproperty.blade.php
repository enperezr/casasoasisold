<tr id="{{ $property->id }}">
    <td class="text-center metadata">
        {{ $property->id }}
        <p>
            <span><a class="trigger_images">{{ $property->images->count() }}<i class="fa fa-photo"></i></a></span>
            <span><a class="trigger_comments">{{ $property->reviews->count() }}<i class="fa fa-comment"></i></a></span>
        </p>
    </td>
    <td>
        {{ substr($property->user->name, 0, 9) . '(' . $property->user->rol->name[0] . ')' }}
        @if ($property->comercial_id)
            <span class="green">{{ substr($property->comercial->name, 0, 9) }}</span>
        @endif
    </td>
    <td id="c{{ $property->actions[0]->contact->id }}">
        {{ $property->actions[0]->contact->names }}
        {{ $property->actions[0]->contact->phones }}
        {{ $property->actions[0]->contact->mail }}
        @if ($property->gestor)
            <br>
            <span class="gestor">gestor</span>
        @endif
        @if (Auth::user()->rol->name != 'comercial')
            <a class="edit trigger_contact"><i class="fa fa-edit"></i></a>
        @endif
    </td>
    <td>
        {{$property->actions[0]->price ? $property->actions[0]->price . ' ' . ($property->actions[0]->currency ? $property->actions[0]->currency->slugged : '') : $property->actions[0]->condition }}
        @if ($property->actions->count() == 2)
            or
            {{ $property->actions[1]->price ? $property->actions[1]->price . ' ' . ($property->actions[1]->currency ? $property->actions[1]->currency->slugged : ''): $property->actions[1]->condition }}
        @endif
        @if (Auth::user()->rol->name != 'comercial')
            <a class="edit trigger_action"><i class="fa fa-edit"></i></a>
        @endif
    </td>
    <td>
        {{ $property->province->name . ', ' . $property->municipio->name }}
        <p>{{ $property->address }}</p>
    </td>
    <td>
        <?php
        $daysPassed = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property->date));
        ?>
        {{ $property->actions[0]->time - $daysPassed <= 0 ? 0 : $property->actions[0]->time - $daysPassed }} from
        {{ $property->actions[0]->time }}
        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property->date)->format('Y/m/d') }}
        @if ($allowed_rols->contains(Auth::user()->rol->id))
            <button class="small button renovate @if ($property->plan_id == 0) success @endif ">
                @if ($property->plan_id != 0)
                    Renovate
                @else
                    Add Plan
                @endif
            </button>
            <a class="fix" href="#"><i class="fa fa-warning"></i></a>
        @endif
        @if (Auth::user()->rol->name == 'admin')
            <a class="edit trigger_days"><i class="fa fa-edit"></i></a>
        @endif
    </td>
    <td>
        {{ $property->actions[0]->user_plan ? $property->actions[0]->user_plan->days : 0 }}
    </td>
    <td>
        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property->created_at)->format('Y/m/d') }}
    </td>
    <td class="text-center">
        <input type="checkbox" name="active" class="trigger_active" {{ $property->active ? 'checked' : '' }}
            {{ $allowed_rols->contains(Auth::user()->rol) && $property->plan_id ? '' : 'disabled="disabled"' }}>
    </td>
    <td class="text-center">
        <input type="checkbox" name="concluded" class="trigger_concluded"
            {{ $property->actions[0]->concluded ? 'checked' : '' }}
            @if (Auth::user()->rol->name == 'comercial') disabled="disabled" @endif>
    </td>
    <td class="text-center">
        @if (Auth::user()->rol->name == 'admin' || ($property->plan_id == 0 && Auth::user()->rol->name != 'comercial'))
            <a href="#" class="delete trigger_delete"><i class="fa fa-trash"></i></a>
        @endif
        <!--
        <a href="#" class="{{ str_contains($property->promocioned, 'rev') ? 'sended ' : '' }}trigger_revo"><img src="{{ asset('images/icons/revo.png') }}"></a>
        -->
        @if (Auth::user()->rol->name != 'comercial')
            <a href="{{ \App\Helper::getPathFor('user/modify/property/' . $property->id) }}" target="_blank"><i
                    class="fa fa-edit"></i></a>
        @endif
        <a href="{{ $property->getUrl($property->actions[0]) }}" target="_blank"><i class="fa fa-eye"></i></a>
    </td>
</tr>

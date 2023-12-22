<div class="user-action" data-id="{{$action->id}}">
        <div class="row">
            <div class="medium-1 column">
                <div class="id-data">
                    <h3>{{$action->id}}</h3>
                </div>
                <div class="state">
                    <span>{{$action->concluded ? ($action->action->id == 1) ? trans('messages.words.sold') : trans('messages.words.permutada') : ''}}</span>
                </div>
                    <?php $daysPassed = \Carbon\Carbon::today()->diffInDays($action->updated_at);?>
                    @if($action->time - $daysPassed <= 0)
                        <div class="days warning">
                            <i class="fa fa-warning" title="{{trans('messages.app.all.time.consumed')}}"></i>
                    @else
                        <div class="days">
                        <span title="{{trans('messages.app.still.left').' '.($action->time - $daysPassed).' '.trans_choice('messages.words.day', 2)}}">{{$action->time - $daysPassed.' '.trans_choice('messages.words.day', 2)}} </span>
                    @endif
                </div>
            </div>
            <div class="large-8 columns">
                <div class="details">
                    <span class="name">{{trans('messages.db.action.'.$action->action->slugged)}}</span>
                    <div class="entry-features">
                        <span class="price">
                            @if($action->price != '')
                                {{$action->price}}
                            @else
                                {{$action->condition}}
                            @endif
                        </span>
                        @if($action->frequency)
                            <span>
                                {{trans('messages.words.frequency.'.$action->frequency)}}
                            </span>
                        @endif
                    </div>
                    <div class="description">
                        {{$action->description}}
                    </div>
                </div>
            </div>
            <div class="large-3 columns">
                <div class="actions float-right">
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{\App\Helper::getPathFor('user/modify/action/'.$action->id)}}" class="edit-action">
                                <i class="fa fa-edit"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="operations float-left">
                        <div class="action-properties operations">
                            <div>
                                <span class="title float-left">{{trans_choice('messages.words.property',$action->properties->count())}}</span>
                                <span class="float-left props">
                                    <select name="props">
                                        @foreach($properties as $property)
                                            <?php $flag = true?>
                                            @foreach($action->properties as $ac_prop)
                                                @if($ac_prop->id == $property->id)
                                                    <?php $flag = false?>
                                                @endif
                                            @endforeach
                                            @if($flag)
                                                <option value="{{$property->id}}">{{$property->id}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </span>
                                <span class="plus-action props-trigger"><a href="#"><i class="fa fa-plus-square"></i></a></span>
                                <span class="plus-show"><a href="#"><i class="fa fa-plus"></i></a></span>
                            </div>
                            <div class="props-container">
                                <ul class="inline-list">
                                    @foreach($action->properties as $p)
                                        <li><span class="bullet orange">{{$p->id}}<i class="fa fa-trash trash-p"></i></span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="action-contact operations">
                            <div>
                                <span class="title float-left">{{trans_choice('messages.words.contact',1)}}</span>
                                <span class="float-left conts">
                                    <select name="conts">
                                        @if($action->contact_id == null)
                                            @foreach($contacts as $contact)
                                                <option value="{{$contact->id}}">{{$contact->id}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </span>
                                <span class="plus-action conts-trigger"><a href="#"><i class="fa fa-plus-square"></i></a></span>
                                <span class="plus-show"><a href="#"><i class="fa fa-plus"></i></a></span>
                            </div>
                            <div class="conts-container">
                                <ul class="inline-list">
                                    @if($action->contact_id)
                                        <li><span class="bullet blue">{{$action->contact_id}}<i class="fa fa-trash trash-c"></i></span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                </div>
            </div>
        </div>
</div>
<div class="user-contact" data-id="{{$contact->id}}">
    <div class="id-data display-inline">
        <h3>{{$contact->id}}</h3>
    </div>
    <div class="details display-inline">
        <span class="name show-for-medium">{{$contact->names}}</span>
        <div class="entry-features">
            <div class="contact-details">
                <p class="phone"><i class="fa fa-mobile-phone"></i> {{$contact->phones}}({{$contact->getHoursAndDays()}})</p>
                @if($contact->mail)
                    <div class="mail"><i class="fa fa-envelope"></i> {{$contact->mail}}</div>
                @endif
            </div>
        </div>
    </div>
    <div class="actions display-inline float-right">
        <a href="{{\App\Helper::getPathFor('user/modify/contact/'.$contact->id)}}" class="edit-contact">
            <i class="fa fa-edit"></i>
        </a>
        <a href="#" class="delete">
            <i class="fa fa-trash"></i>
        </a>
    </div>
</div>
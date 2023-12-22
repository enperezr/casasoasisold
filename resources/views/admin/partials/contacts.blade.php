<div class="row contacts_container">
    <div class="medium-12 columns">
        <h3>Contact For Property {{$property_id}}</h3>
        <form class="contact_form">
            <input type="hidden" value="{{$contact->id}}" name="id"/>
            <label for="names">Names: </label><input type="text" name="names" id="names" value="{{$contact->names}}"/>
            <label for="phones">Phones: </label><input type="text" name="phones" id="phones" value="{{$contact->phones or 'no phone'}}"/>
            <label for="email">Emails: </label><input type="text" name="email" id="email" value="{{$contact->mail or 'no mail'}}"/>
            <span class="command_line"><button class="button read-more save">SAVE</button><button class="button cancel">CANCEL</button></span>
        </form>
    </div>
</div>
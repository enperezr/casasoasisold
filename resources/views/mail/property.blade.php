<html>
<head></head>
<body>
<h3>Nueva propiedad</h3>
<hr>
<h4>Estos son los datos de contacto que hemos recibido</h4>
<p> {!! $contact->toString() !!}</p>
<hr>
@if(isset($property))
    <h4>Estos son los datos de la propiedad que hemos recibido</h4>
    <p> {!! $property->toString() !!}</p>
    <hr>
@endif
@if(isset($action))
    <h4>Estos son los datos de las operaciones que hemos recibido</h4>
    @if(is_array($action))
        @foreach($action as $a)
            <p>{!! $a->toString() !!}</p>
        @endforeach
    @else
        <p>{!! $action->toString() !!}</p>
    @endif
@endif
<h4>Esta es toda la información que hemos recibido</h4>
<p>
    <?php
    $html = '';
    foreach($info as $key=>$value){
        $html.="<span><strong>$key: </strong>";
        if(is_array($value))
            $value = json_encode($value);
        $html.=$value."</span><strong> | </strong>";
    }
    echo $html;
    ?>
</p>
</body>
</html>
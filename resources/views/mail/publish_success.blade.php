<html>
    <head></head>
    <body>
        <h3>Enhorabuena!! Tu propiedad ha sido creada y podrás verla en {{$property->getUrl($action)}} en cuanto
            sea moderada. Te contactaremos en poco tiempo</h3>
        <hr>
        <h4>Estos son los datos de contacto que hemos recibido</h4>
        <p> {!! $contact->toString() !!}</p>
        <hr>
        <h4>Estos son los datos de la propiedad que hemos recibido</h4>
        <p> {!! $property->toString() !!}</p>
        <hr>
        <h4>Estos son datos de la operación que quieres realizar</h4>
        <p> {!! $propertyAction->toString() !!}</p>
        <hr>
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
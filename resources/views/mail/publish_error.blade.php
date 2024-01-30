<html>
    <head></head>
    <body>
        <h3>Lo sentimos hemos encontrado un error en tu publicación</h3>
        <hr>
        <h4>El tipo del error es {{$type}}</h4>
        <strong>Mensaje</strong><p>{{$errors}}</p>
        @if($data)
            <hr>
            <h4>Esta es la información que hemos recibido</h4>
            <p>
                <?php
                $html = '';
                foreach($data as $key=>$value){
                    $html.="<span><strong>$key: </strong>$value</span><strong> | </strong>";
                }
                echo $html;
                ?>
            </p>
        @endif
    </body>
</html>
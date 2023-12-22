<html>
    <head></head>
    <body>
        <h3>Este mensaje es una solicitud en la propiedad {{$property->id}}</h3>
        <hr>
        <h4>Datos de la contacto de la propiedad</h4>
        <p> {!! $action->contact->toString() !!}</p>
        <hr>
        <h4>Datos de la propiedad</h4>
        <p> {!! $property->toString() !!}</p>
        <hr>
        <h4>Datos de la Operación</h4>
        <p> {!! $action->toString() !!}</p>
        <hr>
        <h4>Datos del Solicitante</h4>
        <strong>Nombre:</strong><p>{{$name}}</p>
        <strong>E-mail:</strong><p>{{$email}}</p>
        <strong>Comentario:</strong><p>{{$comment}}</p>
    </body>
</html>
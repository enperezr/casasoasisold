<html>
    <head></head>
    <body>
        <h3>Este mensaje es una reservación en la propiedad {{$property->id}}</h3>
        <hr>
        <h4>Datos de la contacto de la propiedad</h4>
        <p> {!! $property->actionPivot($action)->contact->toString() !!}</p>
        <hr>
        <h4>Datos de la propiedad</h4>
        <p> {!! $property->toString() !!}</p>
        <hr>
        <h4>Datos de la Reservación</h4>
        <p> {!! $reservation->toString() !!}</p>
        <hr>
    </body>
</html>
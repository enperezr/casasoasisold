<html>
<head>
    <title>Nuevo comentario en propiedad</title>
</head>
<body>
<div>
    <p>Una de sus propiedades ha recibido comentarios; la que tiene dirección {{$review->property->address}}</p>
    <p>{{$review->name ? $review->name : 'anónimo'}} con correo {{$review->email}} ha escrito:</p>
    <p>{{$review->text}}</p>
    <p>fecha: {{$review->created_at}}</p>
</div>
<div></div>
</body>
</html>
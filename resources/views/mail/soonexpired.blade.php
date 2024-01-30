<html>
<head>
    <title>Una de sus propiedades no se mostrará más en poco tiempo en Habana Oasis</title>
</head>
<body>
    <p>Hola, una de sus publicaciones en Habana Oasis, la que se encuentra localizada en <strong>{{$data->address}}</strong>
        dejará de verse en aproximadamente {{$days}} días. Esto es porque usted reservó {{$data->time}}
        días({{$data->time > 30 ? ($data->time/30).' meses' : ''}}) en fecha {{$data->created_at}}. Si desea continuar
        apareciendo en Habana Oasis contáctenos al +5358421441. Gracias</p>
    <p>El equipo de Habana Oasis</p>
</body>
</html>
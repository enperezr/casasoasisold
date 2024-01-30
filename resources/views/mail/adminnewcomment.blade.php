<html>
<head>
    <title>Nuevo comentario en propiedad {{$review->property_id}}</title>
</head>
<body>
<div>
    <p><span><strong>correo:</strong></span> {{$review->email}}</p>
    <p><span><strong>nombre:</strong></span> {{$review->name}}</p>
    <p><span><strong>El texto es:</strong></span></p>
    <p>{{$review->text}}</p>
    <p><span><strong>Fecha:</strong></span> {{$review->created_at}}</p>
    <p><span><strong>Id en BD:</strong></span> {{$review->id}}</p>
</div>
<div></div>
</body>
</html>
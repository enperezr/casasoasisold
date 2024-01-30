<html>
<head>
    <title>{{count($data)}} expiradas hoy</title>
    <style>
        table tr{
            border: 1px darkolivegreen solid;
        }
    </style>
</head>
<body>
<table>
    @foreach($data as $expired)
        <tr>
            <td>id: {{$expired->id}}</td>
            <td>phone: {{$expired->phones}}</td>
            <td>mail: {{$expired->mail}}</td>
            <td>fecha: {{$expired->created_at}}</td>
            <td>tiempo: {{$expired->time}} días</td>
            <td>dirección: {{$expired->address}}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
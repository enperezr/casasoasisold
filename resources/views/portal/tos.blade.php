@section('styles')
    <link rel="stylesheet" href="{{asset('css/contactus.css')}}">
@endsection
@section('description', trans('messages.app.tos.description'))
@section('keywords', trans('messages.app.keywords'))
@extends($apk ? 'layout.apk' : 'layout.master')
@section('title', trans('messages.app.tos'))
@section('canonical')
    <link rel="canonical" href="{{Request::url()}}">
@endsection
@section('google')
    @include('portal.google-ads')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="large-12 columns">
                @if($apk)
                <div class="block">
                    <p class="text-center">
                    <a href="{{URL::previous()}}">Regresar a la publicación</a>
                    </p>
                </div>
                @endif
                <div class="block">
                    <h1 class="title">Términos y Condiciones</h1>
                    <h5>Al publicador, La persona que agrega su propiedad con intención de gestionar su operación de venta o permuta</h5>
                    <ol>
                        <li>
                            <p>
                                Su información se publica de acuerdo a la Política de Privacidad y Tratamiento de Datos descrita debajo.
                                Habana Oasis no se hace responsable en ningún modo del uso que de esta información pública puedan hacer
                                terceros que visiten el sitio y la obtengan.
                            </p>
                        </li>
                        <li>
                            <p>
                                Habana Oasis no se hace responsable del envío de mensajes o comentarios ofensivos a través de nuestro sitio. Lo cual no
                                nos exenta de hacer el mejor esfuerzo para evitar que esto suceda, y en el caso de ocurrir tomar las medidas
                                posibles para evitar su recurrencia.
                            </p>
                        </li>
                        <li>
                            <p>
                                Habana Oasis prestará toda la asistencia que requieran los órganos de justicia de acuerdo a la legislación vigente
                                en caso de solicitarla.
                            </p>
                        </li>
                        <li>
                            <p>
                                Habana Oasis podrá eliminar/despublicar cualquier publicación de un usuario si comprueba que es fraude o cualquier
                                forma de estafa, sin previo aviso ni obligación de indemnizar al usuario.
                            </p>
                        </li>
                    </ol>
                    <h5>Al usuario que busca publicaciones como potencial interesado</h5>
                    <ol>
                        <li>
                            Habana Oasis no garantiza veracidad en los datos obtenidos de la publicación de un usuario. Lo cual no nos exenta de
                            comprobar y proceder en la medida de lo posible sobre cualquier denuncia o dato incorrecto encontrado y reportado por un
                            usuario.
                        </li>
                    </ol>
                    <h5>Además:</h5>
                    <ol>
                        <li>
                            <p>
                                Habana Oasis tratará siempre de prestar el mejor servicio pero por razones ajenas a su voluntad le resulta imposible
                                garantizar disponibilidad constante del servicio a ninguno de sus usuarios.
                            </p>
                        </li>
                        <li>
                            <p>
                                Al utilizar nuestro sitio usted acepta los puntos antes expuestos en cada caso.
                            </p>
                        </li>
                        <li>
                            <p>
                                Los presentes Términos y Condiciones podrán ser modificados por Habana Oasis en cualquier momento y se entenderán vigente a partir de ese momento.
                                En dicho caso, se incluirá la política revisada en el Sitio Web y si usted es un usuario registrado, se la enviaremos por correo electrónico.
                            </p>
                        </li>
                    </ol>
                    <p>Para solventar cualquier duda con respeto a la interpretación, aceptación o alcance de estaos términos, por favor contáctenos a través de info@habanaoasis.com</p>
                </div>
                <div class="block" id="privacidad">
                    <h3 class="title">Política de privacidad y Tratamiento de Datos</h3>
                    <p class="description">
                        Toda la información de carácter personal que usted provea a <strong>Habana Oasis</strong> será respetada y protegida.
                        Nunca será utilizada para fines que no aparezcan estipulados en este documento. Su privacidad nos importa
                        por eso es importante que conozca todo lo que hacemos y no hacemos con su información.
                    </p>
                    <p><strong>Al usar Habana Oasis usted acepta las normativas reflejadas en este documento</strong></p>
                    <p>
                        No comunicaremos a terceros su información de carácter personal, salvo en la forma establecida en esta Política sobre Privacidad y Tratamiento de Datos.
                        Habana Oasis podrá revelar cualquier información, incluyendo datos de carácter personal, que considere necesaria para dar cumplimiento a las obligaciones legales.
                    </p>
                    <h5>1. Recogida y Uso de la Información</h5>
                    <p>Al facilitarnos sus datos de carácter personal en Habana Oasis, está expresando su aceptación al tratamiento
                        y comunicación de sus datos personales en la forma contemplada en esta Política sobre Tratamiento de Datos Personales.
                        Si prefiere que Habana Oasis no recabe información personal acerca de usted, rogamos que no nos la facilite.
                    <p>
                        Habana Oasis podrá usar la información de carácter personal que nos facilite de forma disociada (sin identificación personal) para fines internos,
                        como puede ser la elaboración de estadísticas. Así, Habana Oasis podrá recabar, almacenar o acumular determinada información de carácter no personal referente a su uso del Sitio Web,
                        como por ejemplo aquella información que indique cuáles de nuestras páginas son más populares.
                    </p>
                    <p>
                        Mucha de la información que usted ofrece se publica de acuerdo a la misión de Habana Oasis. Los datos de su casa están disponibles e indexados
                        para facilitar que potenciales interesados encuentren su casa. A estos efectos todos los datos en el formulario <strong>publicar propiedad</strong> están disponibles a todos los usuarios.
                        Los datos recogidos en el <strong>formulario de operación</strong> también son públicos. En los <strong>datos de contacto</strong> teléfono y nombre son publicados. <strong>El correo no lo es</strong>,
                        lo que permite que si usted solo provee su dirección de correo electrónico, puede proteger sus datos y aun así ser contactado a través de Habana Oasis con la dirección de correo
                        del remitente y entonces decidir si responderle o no.
                    </p>
                    <p>
                        Usted será contactado por Habana Oasis:
                    <ul>
                        <li>Cuando alguien le envíe un mensaje por su publicación, con el correo del remitente</li>
                        <li>Cuando alguien publique un comentario en su publicación, con el correo del comentador</li>
                        <li>Cuando el tiempo de su publicación este cerca de expirar, dos veces</li>
                        <li>Cuando el tiempo de su publicación haya expirado.</li>
                        <li>Cuando el equipo de Habana Oasis necesite hacerlo. Estos casos serán mínimos</li>
                    </ul>
                    </p>
                    <h5>2. Cookies y Archivos de registro</h5>
                    <p>
                        Habana Oasis podrá colocar “cookies” en el disco duro de su ordenador a fin de reconocerlo como usuario recurrente y personalizar su uso del Sitio Web. La cookie se guardará en el disco duro
                        de su ordenador hasta que usted la elimine. Podrá hacer que su navegador le avise de la presencia de cookies o que los rechace automáticamente. Si rechaza las cookies podrá seguir usando el Sitio Web,
                        si bien ello podrá suponer la limitación en el uso de algunas de las prestaciones o impedir el buen funcionamiento del mismo.
                    </p>
                    <p>Otros servicios utilizados por Habana Oasis para la recopilación de datos estadísticos como Google Analitics, también pueden dejar "cookies" en su ordenador</p>
                    <h5>3. Terceros</h5>
                    <p>
                        Su información podrá ser compartida con terceros:
                    <ul>
                        <li>En casos de requerimiento legal</li>
                        <li>Para facilitar su promoción en redes sociales y sitios afines, este comportamiento puede ser desactivado por usted</li>
                    </ul>
                    </p>
                    <h6>Google Analytics:</h6>
                    <p>
                        Google Analytics es un servicio analítico de web prestado por Google, Inc., una compañía de Delaware cuya oficina principal está en 1600 Amphitheatre Parkway, Mountain View (California), CA 94043, Estados Unidos (“Google”).
                        Google Analytics utiliza “cookies”, que son archivos de texto ubicados en su ordenador, para ayudar al Sitio Web a analizar el uso que hacen los usuarios del Sitio Web. La información que genera la cookie acerca de su uso
                        del Sitio Web (incluyendo su dirección IP) será directamente transmitida y archivada por Google en los servidores de Estados Unidos. Google usará esta información por cuenta nuestra con el propósito de seguir la pista de
                        su uso del Sitio Web, recopilando informes de la actividad del Sitio Web y prestando otros servicios relacionados con la actividad del Sitio Web y el uso de Internet. Google podrá transmitir dicha información a terceros cuando
                        así se lo requiera la legislación, o cuando dichos terceros procesen la información por cuenta de Google. Google no asociará su dirección IP con ningún otro dato del que disponga Google. Puede Usted rechazar el tratamiento
                        de los datos o la información rechazando el uso de cookies mediante la selección de la configuración apropiada de su navegador, sin embargo, debe usted saber que si lo hace puede ser que el sitio no funcione plenamente.
                        Al utilizar este Sitio Web, usted consiente el tratamiento de información acerca de Usted por Google en la forma y para los fines arriba indicados.
                    </p>
                    <h5>5. Seguridad</h5>
                    <p>Habana Oasis ha implantado diversas medidas para proteger la seguridad de su información personal, tanto “on line” como “off line”.</p>
                    <h5>6. Notificación de Cambios</h5>
                    <p>
                        La presente Política sobre Tratamiento de Datos Personales podrá ser modificada por Habana Oasis en cualquier momento y se entenderá vigente a partir de dicho momento. En dicho caso, se incluirá la política revisada en el Sitio Web
                        y si usted es un usuario registrado, se la enviaremos por correo electrónico.
                    </p>
                    <p>Para solventar cualquier duda con respeto a la interpretación, aceptación o alcance de estas políticas, por favor contáctenos a través de info@habanaoasis.com</p>
                </div>
            </div>
        </div>
    </div>
@endsection
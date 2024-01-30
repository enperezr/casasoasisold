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
                <div class="block" style="text-align:justify;">
                    <h1 class="title">Términos y Condiciones</h1>
                    <h5>Al publicar su propiedad inmobiliaria en nuestro Sitio Web, usted, en su calidad de publicador, acepta que:</h5>
                    <ol>
                        <li>
                            <p>
                               Su información se publique de acuerdo con nuestra Política de Privacidad y Tratamiento de Datos, la cual se describe a continuación.
                            </p>
                        </li>
                        <li>
                            <p>
                                La información que usted proporciona al publicar la propiedad en nuestro Sitio Web, incluyendo, pero no limitado a su nombre, número de teléfono, dirección de la propiedad, detalles de la propiedad y fotografías, se considerará información pública y estará disponible para que otros usuarios la vean en nuestro Sitio Web.
                            </p>
                        </li>
                        <li>
                            <p>
                                Casas Oasis no asume responsabilidad por el uso que terceros puedan hacer de esta información pública. Instamos a los usuarios a ser cautelosos al proporcionar información personal y a asegurarse de que la misma sea precisa y esté actualizada.
                            </p>
                        </li>
                        <li>
                            <p>
                                Casas Oasis se reserva el derecho de eliminar o des-publicar cualquier anuncio de un usuario si determina que está asociado con cualquier actividad fraudulenta, información falsa o malintencionada, sin necesidad de previo aviso ni obligación de indemnizar al usuario.
                            </p>
                        </li>
                        <li>
                            <p>
                                Al utilizar nuestro sitio web, los usuarios reconocen que Casas Oasis no puede garantizar la veracidad de los datos proporcionados por otros usuarios. Recomendamos a los usuarios realizar su propia investigación y verificación antes de tomar cualquier decisión basada en la información publicada en el sitio web.
                            </p>
                        </li>
                        <li>
                            <p>
                                Casas Oasis se compromete a brindar el mejor servicio posible, pero no podemos garantizar la disponibilidad constante del servicio debido a posibles interrupciones técnicas o circunstancias fuera de nuestro control.
                            </p>
                        </li>
                        <li>
                            <p>
                                Los usuarios entienden y aceptan que cualquier transacción o negociación realizada como resultado de la información publicada en el sitio web se lleva a cabo bajo su propio riesgo y responsabilidad. Casas Oasis no asume responsabilidad por ninguna transacción o acuerdo entre los usuarios.
                            </p>
                        </li>
                        <li>
                            <p>
                                Casas Oasis no asume responsabilidad por los comentarios, opiniones o mensajes ofensivos que los usuarios puedan publicar en el sitio web. Sin embargo, nos comprometemos a tomar medidas para prevenir y eliminar contenido inapropiado en la medida de lo posible.
                            </p>
                        </li>
                        <li>
                            <p>
                                Para resolver cualquier duda o consulta relacionada con estos términos y condiciones, los usuarios pueden ponerse en contacto con nosotros a través de <a href="mailto:info@casasoasis.com">info@casasoasis.com</a>.
                            </p>
                        </li>
                    </ol>
                    <p>
                        Estos Términos y Condiciones pueden ser modificados por Casas Oasis en cualquier momento y dichas modificaciones entrarán en vigencia a partir de ese momento. Recomendamos a los usuarios revisar periódicamente los términos y condiciones actualizados. Los cambios se comunicarán a los usuarios registrados por correo electrónico y se publicarán en el sitio web.
                    </p>
                </div>
                <div class="block" id="privacidad" style="text-align: justify;">
                        <h3 class="title">Política de privacidad y Tratamiento de Datos</h3>
                        <p class="description">
                            En Casas Oasis, valoramos y protegemos su información personal. Nos comprometemos a utilizarla únicamente para los fines establecidos en este documento y a respetar su privacidad. Al utilizar Casas Oasis, usted acepta cumplir con las normativas descritas en esta Política de Privacidad y Tratamiento de Datos.
                        </p>
                        <h5>1. Recopilación y Uso de la Información</h5>
                        <p>
                            Al proporcionarnos su información personal en Casas Oasis, usted acepta el tratamiento y la comunicación de sus datos personales de acuerdo con esta Política de Tratamiento de Datos Personales. Si prefiere que Casas Oasis no recopile la información personal que usted voluntariamente introducirá en nuestro sitio web, le recomendamos que no la proporcione.
                        <p>
                            Casas Oasis puede utilizar la información personal que nos brinde de forma disociada (sin identificación personal) para fines internos, como la elaboración de estadísticas. Además, podemos recopilar, almacenar o acumular información no personal relacionada con su uso del Sitio Web, como datos que indiquen qué páginas son las más populares.
                        </p>
                        <p>
                            Algunos de los datos que usted proporciona se publican para cumplir con la misión de Casas Oasis. Los detalles de su propiedad están disponibles e indexados para facilitar que posibles interesados encuentren su propiedad. Para este propósito, todos los datos en el formulario de publicación de propiedad están disponibles para todos los usuarios.
                        </p>
                        <p>
                            Los datos recopilados en el formulario de operación también son públicos. Los datos de contacto, como el número de teléfono y el nombre, se publican, mientras que el correo electrónico no se hace público, excepto si usted lo incluye en la descripción de su propiedad inmobiliaria, en la sección de Descripción, al llenar el formulario.
                        </p>
                        <p>
                            Conocer esto le permite proteger sus datos y, al mismo tiempo, ser contactado a través de Casas Oasis mediante la dirección de correo del remitente. De esta manera, puede decidir si responder o no.
                        </p>

                        <p>
                            <strong>Usted será contactado por Habana Oasis:</strong>
                        <ul>
                            <li>Cuando alguien le envíe un mensaje relacionado con su publicación, con la dirección de correo del remitente.</li>
                            <li>Cuando alguien publique un comentario en su publicación, con la dirección de correo del comentador.</li>
                            <li>Cuando alguien denuncie su publicación y necesitemos confirmar la veracidad de la información proporcionada por usted. </li>
                            <li>Cuando el tiempo de su publicación esté cerca de expirar, en dos ocasiones.</li>
                            <li>Cuando el tiempo de su publicación haya expirado.</li>
                            <li>Cuando anunciemos alguna novedad o modificación en nuestros servicios, incluyendo nuevas ofertas que pudieran ser de su interés. </li>
                            <li>En caso de que usted se suscriba a alguno de nuestros servicios que incluyan notificarle cuando cierto contenido sea publicado en nuestro sitio web. </li>
                            <li>Cuando el equipo de Casas Oasis necesite contactarle. Estos casos serán mínimos.</li>
                        </ul>
                        </p>
                        <h5>2. Cookies y Archivos de registro</h5>
                        <p>
                            Casas Oasis puede utilizar "cookies" para reconocerlo como usuario recurrente y personalizar su experiencia en el Sitio Web. Estas cookies se almacenarán en el disco duro de su ordenador hasta que usted las elimine. Puede configurar su navegador para que le notifique la presencia de cookies o las rechace automáticamente. Tenga en cuenta que rechazar las cookies puede limitar algunas funciones o afectar el correcto funcionamiento del Sitio Web.
                        </p>
                        <p>También utilizamos servicios de terceros, como Google Analytics, para recopilar datos estadísticos. Estos servicios también pueden utilizar cookies en su ordenador.</p>
                        <h5>3. Compartir con Terceros</h5>
                        <p>
                            Su información puede ser compartida con terceros en los siguientes casos:
                        <ul>
                            <li>Cuando sea requerido por ley.</li>
                            <li>Para facilitar su promoción en redes sociales y sitios relacionados. Puede desactivar esta función si lo desea.</li>
                        </ul>
                        </p>
                        <h6>Google Analytics:</h6>
                        <p>
                            Google Analytics es un servicio analítico web proporcionado por Google, Inc., una compañía con sede en Estados Unidos. Google Analytics utiliza cookies para analizar el uso que los usuarios hacen del Sitio Web. La información generada por la cookie, incluyendo su dirección IP, se transmitirá y almacenará en los servidores de Google en Estados Unidos. Google utilizará esta información en nuestro nombre para evaluar el uso del Sitio Web, recopilar informes sobre la actividad del Sitio Web y proporcionar otros servicios relacionados con dicha actividad y el uso de Internet. Google puede transmitir esta información a terceros cuando así lo requiera la ley o cuando dichos terceros procesen la información en nombre de Google. Google no asociará su dirección IP con ningún otro dato del que disponga. Puede rechazar el uso de cookies seleccionando la configuración apropiada en su navegador, pero tenga en cuenta que esto puede afectar el funcionamiento completo del sitio. Al utilizar este Sitio Web, usted acepta el tratamiento de su información por parte de Google en la forma y para los fines descritos anteriormente.
                        </p>
                        <h5>5. Seguridad</h5>
                        <p>Casas Oasis se compromete a tomar todas las precauciones razonables para salvaguardar los datos personales de sus usuarios, tanto en línea como fuera de línea.</p>
                        <h5>6. Notificación de Cambios</h5>
                        <p>
                            La presente Política de Tratamiento de Datos Personales puede ser modificada por Casas Oasis en cualquier momento. La versión actualizada estará disponible en el Sitio Web, y si usted es un usuario registrado, también se le enviará por correo electrónico.
                        </p>
                        <p>
                            Si tiene alguna pregunta sobre la interpretación, aceptación o alcance de estas políticas, no dude en ponerse en contacto con nosotros a través de <a href="mailto:info@casasoasis.com">info@casasoasis.com</a>. Estaremos encantados de ayudarle.
                        </p>
                      </div>
            </div>
        </div>
    </div>
@endsection
@section('opengraph')
    <meta property="og:title" content="{{trans('messages.app.welcome')}}">
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:image" content="{{asset('images/video.jpg')}}"/>
    <meta property="og:type" content="product"/>
    <meta property="og:description" content="{{trans('messages.app.description')}}"/>
@endsection
@section('styles')

@endsection
@section('scripts')
<script data-schema="Organization" type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "Organization",
    "@id":"https://habanaoasis.com/contactenos",
    "name": "Habana Oasis",
    "logo":{"@type":"ImageObject","url":"https://habanaoasis.com/images/video.jpg","width":409,"height":227},
    "url": "https://habanaoasis.com",
    "sameAs": [
	 "https://twitter.com/HabanaOasis",
     "https://www.facebook.com/habanaoasis"
    ]
  }
</script>

<script type="application/ld+json">
  {"@context": "https://schema.org","@type": "WebSite","url": "https://habanaoasis.com/"}
</script>

@endsection

@section('description', trans('messages.app.description'))
@section('keywords', trans('messages.app.keywords'))
@section('title', trans('messages.app.welcome'))
@section('canonical')
    <link rel="canonical" href="{{Request::url()}}">
@endsection
@extends('layout.bootstrap')
@section('content')
<div id="header" class="row">
  <div class="col my-5 pt-3 text-center">
    <div>
      <h1><strong>La mejor manera de vender tu Casa</strong></h1>
      <h2 class="mb-4 mt-3 font-italic font-weight-bold">Sin comisiones y Sin intermediarios</h2>
    </div>
    <div class="clearfix"></div>
    <a href="#" class="btn btn-warning border rounded-pill mt-4 text-uppercase">Infórmate Gratis</a>
  </div>
</div>
<div id="contact-form-header" class=" row pb-5">
  <div class="col">
    <div id="pitch" class="row text-center">
      <div class="col my-4">
        <h2 class="font-weight-bold">Vender una casa no tiene que ser un problema, Cuenta con Habana Oasis!</h2>
      </div>
    </div>
    <div id="leverage" class="row text-center" >
      <div class="col-lg">
        <h3>+4000</h3>
        <p>Clientes</p>
      </div>
      <div class="col-lg">
          <h3>+130 mil</h3>
          <p>Búsquedas mensuales</p>
      </div>
      <div class="col-lg">
          <h3>+15 casas</h3>
          <p>vendidas por mes</p>
      </div>
    </div>
    <div id="separator"><!--TODO buscar una imagen para separar--></div>
  </div>
</div>
<div id="contact-form" class="container-fluid text-center">
  <div class="form px-5 py-3 d-inline-block">
    <form>
      <fieldset class="p-3">
        <legend class="px-4">Comienza hoy mismo a vender bien tu casa</legend>
        <div class="row my-3">
          <div class="col-md">
            <input type="text" name="name" class="form-control" placeholder="Nombre">
          </div>
          <div class="col-md">
            <input type="text" name="phone" class="form-control" placeholder="Teléfono">
          </div>
        </div>
        <div class="row my-3">
          <div class="col">
            <input type="text" name="email" class="form-control" placeholder="Correo Electrónico">
          </div>
        </div>
        <div class="row my-3">
          <div class="col">
            <textarea name="text" class="form-control">Hola, deseo saber más sobre Habana Oasis.</textarea>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <input type="submit" name="submit" value="enviar" class="btn btn-warning border rounded-pill mt-4 text-uppercase">
          </div>
        </div>
      </fieldset>
    </form>
    <div id="services" class="my-4 text-left">
      <h3 class="my-4 font-weight-bold">Todos los servicios inmobiliarios que necesitas:</h3>
      <ul>
        <li><p>Adios a las comisiones, no pagues un porciento de tu venta, ahorrate miles,
          cobramos un precio fijo, accesible y nada mas que eso.</p></li>
        <li><p>Publicidad acorde a tus necesidades, Llegamos a toda Cuba y el mundo,
          aun sin internet, los interesados podrán encontrarte en nuestra aplicación 
          de escritorio sin conexión, La distribuimos en el paquete semanal para toda Cuba.
        </p></li>
        <li><p>Marqueting de redes sociales, nuestros grupos de Facebook, WhatsApp y Telegram 
          verán tu casa, tenemos miles de miembros activos y publicando</p></li>
        <li><p>No te gusta que te molesten sino van a comprar? contrata el servicio de 
          visita virtual lo incluiremos en la pagina y en la app, podran ver tu casa sin molestarte</p>
        </li>
        <li><p>Servicio a domicilio, Llámanos, nosotros hacemos el resto, en pocos dias enviaremos 
          un comercial a su casa que incluso le tomará las fotos si lo necesita.</p>
        </li>
      </ul>
  </div>
</div>

</div>
<div id="experiences" class="my-4 row px-0">
  <div class="col-9">
    <h2 class="m-5 py-5">Roberto ha vendido su apartamento en el Vedado por $50000</h2>
    <h3>Gracias a nosotros se ha ahorrado $2475</h3>
  </div>
  <div class="col-3">

  </div>
</div>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Página no encontrada</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Arvo'>
  <link rel="stylesheet" href="{{ asset('css/404.css') }}">
</head>
<body>
<section class="page_404">
  <div class="container">
    <div class="row">	
      <div class="col-sm-12 ">
        <div class="col-sm-10 col-sm-offset-1  text-center">
          <div class="four_zero_four_bg">
            <h1 class="text-center">404</h1>
          </div>
          <div class="contant_box_404">
            <h3 class="h2">Parece que estás perdido</h3>
            <p>¡La página que buscas no está disponible!</p>
            <a href="{{ url('/') }}" class="link_404">Ir al Inicio</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>

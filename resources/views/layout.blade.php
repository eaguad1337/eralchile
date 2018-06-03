<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('css/app.css')}}"/>
  <title>ERAL</title>
</head>
<body>

<div id="app">
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Eral</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="#">Inicio</a></li>
        <li><a href="{{route('orders.index')}}">Ordenes</a></li>
        @if(auth()->user()->isAdmin())
        <li><a href="{{route('costcentres.index')}}">Centros de Costo</a></li>
        <li><a href="{{route('users.index')}}">Usuarios</a></li>
        @endif
        <li><a href="{{route('providers.index')}}">Proveedores</a></li>
      </ul>
    </div>
  </nav>

  @include('alerts')

  @yield('content')

</div>

<script src="{{asset('js/app.js')}}"></script>
@stack('scripts')

</body>
</html>

@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-12">
      <h2>Centros de costo</h2>
      <a class="create-link" href="{{route('costcentres.create')}}">Crear nuevo <i class="fa fa-plus-circle"></i></a>
      <hr>
      <table class="table">
        <thead>
        <tr>
          <th>Nombre</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($costCentres as $costCentre)
          <tr>
            <td>{{$costCentre->name}}</td>
            <th><a href="{{route('costcentres.edit', $costCentre->id)}}">Editar</a></th>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop

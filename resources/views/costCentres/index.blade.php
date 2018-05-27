@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-12">
      <h2>Centros de costo</h2>
      <a class="btn btn-primary" href="{{route('costcentres.create')}}">Crear</a>
      <table class="table">
        <thead>
        <tr>
          <th>Nombre</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          @foreach($costCentres as $costCentre)
            <td>{{$costCentre->name}}</td>
            <th><a href="{{route('costcentres.edit', $costCentre->id)}}">Editar</a></th>
          @endforeach
        </tr>
        </tbody>
      </table>
    </div>
  </div>
@stop

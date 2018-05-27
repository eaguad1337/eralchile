@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-12">
      <h2>Ordenes</h2>
      <a class="btn btn-primary" href="{{route('orders.create')}}">Crear</a>
      <table class="table">
        <thead>
        <tr>
          <th>Código</th>
          <th>CECO</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          @foreach($orders as $order)
            <td>{{$order->code}}</td>
            <td>{{$order->costCentre->name}}</td>
            <td>{{$order->status}}</td>
          @endforeach
        </tr>
        </tbody>
      </table>
    </div>
  </div>
@stop

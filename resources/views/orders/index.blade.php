@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-12">
      <h2>Ordenes</h2>
      <div class="row">
        <div class="col-md-6">
          <a class="btn btn-primary" href="{{route('orders.create')}}">Crear</a>
        </div>
        <div class="pull-right">
          {{$orders->links()}}
        </div>
      </div>
      <table class="table">
        <thead>
        <tr>
          <th>Fecha</th>
          <th>Código</th>
          <th>Centro de costo</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
          <tr>
            <td>{{$order->created_at}}</td>
            <td>{{$order->code}}</td>
            <td>{{$order->costCentre->name}}</td>
            <td>{{__($order->status)}}</td>
            <td><a href="{{route('orders.edit', $order->id)}}">Editar</a></td>
          </tr>
        @endforeach
        </tbody>
      </table>
      <div class="row">
        <div class="pull-right">
          {{$orders->links()}}
        </div>
      </div>
    </div>
  </div>
@stop

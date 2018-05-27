@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-8 col-md-offset-2">
      <h2>Crear orden</h2>

      @if(isset($order))
        {!! Form::model($order, ['route' => ['orders.update', $order->id], 'files' => true, 'method' => 'patch']) !!}
      @else
        {!! Form::open(['route' => 'orders.store', 'method' => 'post', 'files' => true]) !!}
      @endif
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="code">Número de orden</label>
            {!! Form::text('code', old('code'), ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="cost_centre_id">Centro de costo</label>
            {!! Form::select('cost_centre_id', $costCentres->pluck('name', 'id'), old('cost_centre_id'), ['class' => 'form-control']) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="file">Adjuntar archivo</label>
            {!! Form::file('file', ['class' => 'form-control']) !!}
          </div>
        </div>
      </div>
      <div class="row">
        {{--<div class="form-group">--}}
          {{--<label for="view">Ver archivo</label>--}}
        {{--</div>--}}
      </div>
      <div class="row">
        <div class="col-md-6">
          <button class="btn btn-primary">Guardar</button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
@stop

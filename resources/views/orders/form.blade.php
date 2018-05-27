@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-8 col-md-offset-2">
      <h2>Crear orden</h2>

      {!! Form::open(['route' => 'orders.store', 'method' => 'post', 'files' => true]) !!}
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
            <select name="cost_centre_id" id="cost_centre_id" class="form-control">
              @foreach($costCentres as $costCentre)
                <option value="{{$costCentre->id}}">{{$costCentre->name}}</option>
              @endforeach
            </select>
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
        <div class="col-md-6">
          <button class="btn btn-primary">Guardar</button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
@stop

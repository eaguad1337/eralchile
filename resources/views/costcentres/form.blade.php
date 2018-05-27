@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-8 col-md-offset-2">
      <h2>Crear Centro de Costo</h2>

      @if(isset($costCentre))
        {!! Form::model($costCentre, ['route' => ['costcentres.update', $costCentre->id], 'method' => 'patch']) !!}
      @else
        {!! Form::open(['route' => 'costcentres.store', 'method' => 'post']) !!}
      @endif
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="code">Nombre</label>
            {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
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

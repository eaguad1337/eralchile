@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-8 col-md-offset-2">

      <h2>Detalles de proveedor</h2>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="name">Nombre</label>
            <p>{{$provider->cardname}}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="name">Código SAP</label>
            <p>{{$provider->cardcode}}</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="country">País</label>
            <p>{{$provider->country}}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="country">Ciudad</label>
            <p>{{$provider->city}}</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="address">Dirección</label>
            <p>{{$provider->address}}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="zipcode">ZipCode</label>
            <p>{{$provider->zipcode}}</p>
          </div>
        </div>
      </div>

    </div>
  </div>
@stop

@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-8 col-md-offset-2">

      @if(isset($user))
        <h2>Actualizar usuario</h2>
        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}
      @else
        <h2>Crear usuario</h2>
        {!! Form::open(['route' => 'users.store', 'method' => 'post']) !!}
      @endif
      <form action="{{route('orders.store')}}">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Nombre</label>
              {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="lastname">Apellido</label>
              {!! Form::text('lastname', old('lastname'), ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="email">Email</label>
              {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="password">Contraseña</label>
              {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="is_active">Estado</label>
              {!! Form::select('is_active', [1 => 'Activo', 0 => 'Inactivo'], old('is_active'), ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="col-md-6">
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <label for="permission_view">Permiso para ver</label>
            {!! Form::checkbox('permission_view', 1, old('permission_view')) !!}
          </div>
          <div class="col-md-3">
            <label for="permission_approver">Permiso para aprobar</label>
            {!! Form::checkbox('permission_approver', 1, old('permission_approver')) !!}
          </div>
          <div class="col-md-3">
            <label for="permission_signatory">Permiso para visar</label>
            {!! Form::checkbox('permission_signatory', 1, old('permission_signatory')) !!}
          </div>
          <div class="col-md-3">
            <label for="permission_admin">Permiso para Administrar</label>
            {!! Form::checkbox('permission_admin', 1, old('permission_admin')) !!}
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

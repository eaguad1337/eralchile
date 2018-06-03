@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-12">
      <h2>Usuarios</h2>
      <a class="create-link" href="{{route('users.create')}}">Crear nuevo <i class="fa fa-plus-circle"></i></a>
      <hr>
      <table class="table">
        <thead>
        <tr>
          <th>Nombre</th>
          <th>Email</th>
          <th>Tipo de usuario</th>
          <th>Puede visar</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
          <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->isAdmin() ? "Administrador" : "Usuario normal"}}</td>
            <td>{{$user->isSignatory() ? "Sí" : "No"}}</td>
            <td>
              <a href="{{route('users.edit', $user->id)}}"><i class="fa fa-pencil"></i> Editar</a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
      <div class="row">
        <div class="pull-right">
          {{$users->links()}}
        </div>
      </div>
    </div>
  </div>
@stop

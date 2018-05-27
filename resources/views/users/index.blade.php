@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-12">
      <h2>Usuarios</h2>
      <a class="btn btn-primary" href="{{route('users.create')}}">Crear</a>
      <table class="table">
        <thead>
        <tr>
          <th>Nombre</th>
          <th>Email</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          @foreach($users as $user)
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
              <a href="{{route('users.edit', $user->id)}}">Editar</a>
            </td>
          @endforeach
        </tr>
        </tbody>
      </table>
    </div>
  </div>
@stop

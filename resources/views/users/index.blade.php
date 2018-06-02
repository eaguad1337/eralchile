@extends('layout')

@section('content')
  <div class="container">
    <div class="col-md-12">
      <h2>Usuarios</h2>
      <div class="row">
        <div class="col-md-4">
          <a class="btn btn-primary" href="{{route('users.create')}}">Crear</a>
        </div>
        <div class="pull-right">
          {{$users->links()}}
        </div>
      </div>
      <hr>
      <table class="table">
        <thead>
        <tr>
          <th>Nombre</th>
          <th>Email</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
          <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
              <a href="{{route('users.edit', $user->id)}}">Editar</a>
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

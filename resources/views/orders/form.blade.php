@extends('layout')

@section('content')
  @php
    $user = auth()->user();
    $orderIsEditable = !isset($order) || ($user->can('approve', $order) || $order->status === \EAguad\Services\OrderService::STATUS_PENDING)
  @endphp

  <div class="container">
    <div class="col-md-8 col-md-offset-2">
      @if(!isset($order))
        <h2>Crear orden</h2>
        {!! Form::open(['route' => 'orders.store', 'method' => 'post', 'files' => true]) !!}
      @else
        <h2>Editar orden</h2>
        {!! Form::model($order, ['route' => ['orders.update', $order->id], 'files' => true, 'method' => 'patch']) !!}
      @endif
      <hr>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="code">Número de orden</label>
            {!! Form::text('code', old('code'), ['class' => 'form-control', 'readonly' => !$orderIsEditable]) !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="approver">Aprobador</label>
            {!! Form::select('approver_id', $approvers, old('approver_id'), ['class' => 'form-control']) !!}
          </div>
        </div>
      </div>
      <div class="row">
        @if(!isset($order))
          <providers-autocomplete
            old-value="{{isset($order) ? $order->provider->cardcode : "" }}">
          </providers-autocomplete>
        @else
          <div class="col-md-6">
            <div class="form-group">
              <label for="provider_cardcode">Proveedor</label>
              <p><a href="{{route('providers.show', $order->provider_id)}}">{{$order->provider->cardname}}</a></p>
            </div>
          </div>
        @endif

        @if($orderIsEditable)
          <div class="col-md-6">
            <div class="form-group">
              <label for="file">Adjuntar archivo</label>
              {!! Form::file('file', ['class' => 'form-control']) !!}
            </div>
          </div>
        @endif
      </div>
      <div class="row">
        @if(isset($order))
          <div class="col-md-6">
            <div class="form-group">
              <label for="status">Cambiar estado</label>
              {!! Form::select('status', $statusSelect, old('status'), ['class' => 'form-control']) !!}
            </div>
          </div>
        @endif
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
      @if(isset($order) || $orderIsEditable)
        {!! Form::close() !!}
      @endif

      @if(isset($order))
        <hr>
        <div class="row">
          <div class="col-md-6">
            <label for="view_pdf">Ver OC</label>
            <div class="view-pdf" style="width: 80px">
              <a href="{{$order->getFirstMediaUrl()}}" target="_blank">
                <img src="/images/pdf.ico" width="100%" alt="">
              </a>
            </div>
          </div>
        </div>

        @if($user->can('approve', $order))
          <hr>
          <div class="row">
            <table class="table">
              <thead>
              <tr>
                <th>Fecha</th>
                <th>Estado anterior</th>
                <th>Nuevo estado</th>
                <th>Usuario</th>
              </tr>
              </thead>
              <tbody>
              @foreach($order->logs as $log)
                <tr>
                  <td>{{$log->created_at}}</td>
                  <td>{{__($log->old_status)}}</td>
                  <td>{{__($log->new_status)}}</td>
                  <td><a href="{{route('users.edit', $log->reviewer->id)}}">{{$log->reviewer->name}}</a></td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        @endif
      @endif
    </div>
  </div>

@stop

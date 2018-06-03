<div class="row">
  <div class="container">
    <div class="col-md-8 col-md-offset-2">
      @if(session()->has('success'))
        <div class="alert alert-success">
          Registro actualizado correctamente.
        </div>
      @endif

      @if(session()->has('error'))
        <div class="alert alert-warning">
          <p>{{session()->get('message')}}</p>
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-warning">
          <p>Por favor verificar lo siguiente</p>
          <ul>
            @foreach($errors->all() as $error)
              <li>{{$error}}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
  </div>
</div>

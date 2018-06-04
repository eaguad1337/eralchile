@extends('layout')

@push('scripts')
  <script>
    token = document.head.querySelector('meta[name="csrf-token"]');
    $(function () {
      $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        language: {
          url: "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
        },
        ajax: {
          url: '{{ route('api.providers.datatables') }}',
          headers: { 'X-CSRF-TOKEN': token.content},
        },
        columns: [
          {data: 'cardcode', name: 'cardcode', render: $.fn.dataTable.render.text()},
          {data: 'cardname', name: 'cardname', render: $.fn.dataTable.render.text()},
          {data: 'country', name: 'country', render: $.fn.dataTable.render.text()},
          {
            name: 'action', orderable: false, searchable: false, render: (data, type, row) => {
              return `<a href="/providers/${row.id}">Detalles</a>`;
            }
          }
        ]
      });
    });
  </script>
@endpush

@section('content')
  <div class="container">
    <div class="col-md-12">
      <h2>Proveedores</h2>

      <hr>
      <div class="row">
        <div class="col-md-12">
          <table class="table" id="dataTable">
            <thead>
            <th name="cardcode">Código SAP</th>
            <th name="cardname">Nombre</th>
            <th name="country">País</th>
            <th name="action">Acciones</th>
            </thead>
          </table>
        </div>
      </div>

    </div>
  </div>
@stop

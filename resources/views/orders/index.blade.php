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
          url: '{{ route('api.orders.datatables') }}',
          headers: { 'X-CSRF-TOKEN': token.content},
        },
        order: [[ 0, "desc" ]],
        columns: [
          {data: 'created_at', name: 'created_at', render: $.fn.dataTable.render.text()},
          {data: 'code', name: 'code', render: $.fn.dataTable.render.text()},
          {data: 'provider', name: 'provider.cardname', render: (data, type, row) => {
              return `<a href="/providers/${row.provider.id}">${row.provider.cardname}</a>`
            }
          },
          {data: 'user', name: 'user.name', render: (data, type, row) => {
              return `<a href="/users/${row.user.id}/edit">${row.user.name}</a>`
            }
        },
          {data: 'status', name: 'status', render: (data, type, row) => {
            const status = {
              'pending': 'Pendiente',
              'approved': 'Aprobada',
              'rejected': 'Rechazada',
              'signed': 'Visada',
              'nulled': 'Anulada',
            };

            return status[row.status];
            }
          },
          {
            name: 'action', orderable: false, searchable: false, render: (data, type, row) => {
              return `<a href="/orders/${row.id}/edit">Detalles</a>`;
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
      <h2>Órdenes</h2>
      <a class="create-link" href="{{route('orders.create')}}">Crear nueva <i class="fa fa-plus-circle"></i></a>

      <hr>
      <div class="row">
        <div class="col-md-12">
          <table class="table" id="dataTable">
            <thead>
            <th name="created_at">Fecha</th>
            <th name="code">No OC</th>
            <th name="provider">Proveedor</th>
            <th name="user">Emisor</th>
            <th name="status">Estado</th>
            <th name="action">Acciones</th>
            </thead>
          </table>
        </div>
      </div>

    </div>
  </div>
@stop

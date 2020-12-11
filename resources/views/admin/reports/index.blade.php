@extends('admin.layout')

@section('header')
    <h1>
        REPORTES
        <small>Listado</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Reportes</li>
    </ol>
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Listado de reportes</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="users-table" class="table table-bordered table-striped text-center">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Fecha Creación</th>
                    <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>
                            {{ trans($report->id) }}
                        </td>
                        <td>
                            {{ trans($report->type) }}
                        </td>
                        <td>{{ $report->created_at->format('m/d/Y - H:i') }}</td>
                        <td>
                            @if($report->file_path)
                                <a href="{{ route('admin.reports.download', $report->id) }}"
                                   class="btn btn-xs btn-info">
                                    <i class="fa fa-download"></i> Descargar
                                </a>
                            @endif
                            <form method="POST"
                                  action="{{ route('admin.reports.destroy', $report->id) }}"
                                  style="display: inline">
                                @CSRF @method('DELETE')
                                <button class="btn btn-xs btn-danger"
                                        onclick="return confirm('Estas seguro de eliminar este reporte? ')">
                                    <i class="fa fa-close"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $reports->links() }}
        </div>
        <!-- /.box-body -->
    </div>
@endsection


@push('styles')

    <link rel="stylesheet" href="/adminlte/plugins/datatables/dataTables.bootstrap.css">

@endpush

@push('scripts')
    <script src="/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script>
        $(function () {
            $('#posts-table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
@endpush

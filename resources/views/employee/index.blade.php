@extends('adminlte::page')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-b-3">Manage Employee</h4>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ul class="breadcrumb ">
                        <li class="breadcrumb-item"><a style="color: #ffc107" href="/">Home</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ul>
                </div>
                <div class="col-sm-6 float-sm-right text-right">
                    <a href="{{ route('employee.create') }}" data-toggle="tooltip" data-title="Create New Employee"
                        class="btn btn-sm btn-warning"><i class="fas fa-plus"></i></a>

                    {{-- <a href="{{ route('export-employees') }}" data-toggle="tooltip" data-title="Print"
                        class="btn btn-sm btn-warning"><i class="fas fa-file-excel"></i></a> --}}
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12">

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>EMPLOYEE ID</th>
                                        <th>NAME</th>
                                        <th>EMAIL</th>
                                        <th>DATE OF JOINING</th>
                                        <th>DIVISION</th>
                                        <th>WORK FROM</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: 'employee',
                "fnDrawCallback": function() {
                    $('[data-toggle="tooltip"]').tooltip();
                },
                columns: [{
                        data: 'employee_id',
                        name: 'employee_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: function(row) {
                            let utcDate = row.doj;
                            let local = moment.utc(utcDate, 'YYYY-MM-DD').local().format(
                                "DD MMM YYYY");
                            return local;
                        },
                        name: 'doj'
                    },
                    {
                        data: 'division',
                        name: 'division'
                    },
                    {
                        data: 'work_from',
                        name: 'work_from'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush

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
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ul>
                </div>
                <div class="col-sm-6 float-sm-right text-right">
                    <a href="#" data-url="{{ route('employee.create') }}" data-ajax-popup="true" data-toggle="tooltip"
                        data-title="Create New Employee" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Add
                        Employee</a>
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

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
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
                            var date = new Date(row.doj);
                            var options = {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                            };

                            return date.toLocaleDateString('en-US');
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

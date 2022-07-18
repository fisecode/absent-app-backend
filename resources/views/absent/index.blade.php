@extends('adminlte::page')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-b-3">Manage Absent</h4>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ul class="breadcrumb ">
                        <li class="breadcrumb-item"><a style="color: #ffc107" href="/">Home</a></li>
                        <li class="breadcrumb-item active">Absent</li>
                    </ul>
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
                                        <th>EMPLOYEE</th>
                                        <th>DATE</th>
                                        <th>STATUS</th>
                                        <th>CHECK IN</th>
                                        <th>CHECK OUT</th>
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
                ajax: 'absent',
                "fnDrawCallback": function() {
                    $('[data-toggle="tooltip"]').tooltip();
                },
                columns: [{
                        data: 'employee.name',
                        name: 'employee'
                    },
                    {
                        data: function(row) {
                            let date = row.date;
                            let local = moment(date).local().format(
                                "DD MMM YYYY");
                            return local;
                        },
                        name: 'date'
                    },
                    {
                        data: function(row) {
                            return row.status ? "Present" : "-"
                        },
                        name: 'status'
                    },
                    {
                        data: function(row) {
                            let time = row.check_in;
                            let local = moment(time, "HH:mm:ss").local().format(
                                "HH:mm");
                            return local;
                        },
                        name: 'check_in'
                    },
                    {
                        data: function(row) {
                            let time = row.check_out;
                            let local = moment(time, "HH:mm:ss").local().format(
                                "HH:mm");
                            if (time == null) {
                                return '-';
                            }
                            return local;
                        },
                        name: 'check_out'
                    },
                    {
                        data: 'absent_spot',
                        name: 'absent_spot'
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

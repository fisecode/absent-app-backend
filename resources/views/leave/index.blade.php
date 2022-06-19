@extends('adminlte::page')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-b-3">Manage Leave</h4>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ul class="breadcrumb ">
                        <li class="breadcrumb-item"><a style="color: #ffc107" href="/">Home</a></li>
                        <li class="breadcrumb-item active">Leave</li>
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
                                        <th>LEAVE TYPE</th>
                                        <th>APPLIED ON</th>
                                        <th>START DATE</th>
                                        <th>END DATE</th>
                                        <th>TOTAL DAYS</th>
                                        <th>LEAVE REASON</th>
                                        <th>STATUS</th>
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
                ajax: "leave",
                "fnDrawCallback": function() {
                    $('[data-toggle="tooltip"]').tooltip();
                },
                columns: [{
                        data: 'employee.name',
                        name: 'employee.name'
                    },
                    {
                        data: 'leave_type.name',
                        name: 'leave_type.name'
                    },
                    {
                        data: function(row) {
                            var date = new Date(row.applied_on);
                            var options = {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                            };

                            return date.toLocaleDateString('id-ID', options);
                        },
                        name: 'applied_on'
                    },
                    {
                        data: function(row) {
                            var date = new Date(row.start_date);
                            var options = {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                            };

                            return date.toLocaleDateString('id-ID', options);
                        },
                        name: 'start_date'
                    },
                    {
                        data: function(row) {
                            var date = new Date(row.end_date);
                            var options = {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                            };

                            return date.toLocaleDateString('id-ID', options);
                        },
                        name: 'end_date'
                    },
                    {
                        data: 'total_leave_days',
                        name: 'total_leave_days'
                    },
                    {
                        data: 'leave_reason',
                        name: 'leave_reason'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false,
                        "width": "12%"
                    }
                ]
            });
        });
    </script>
@endpush

@extends('adminlte::page')

@section('content')
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
                        <li class="breadcrumb-item"><a style="color: #ffc107"
                                href="{{ route('absent.index') }}">Absent</a>
                        </li>
                        <li class="breadcrumb-item active">Absent Detail</li>
                    </ul>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

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
        <div class="container-fluid pr-3 pl-3">
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ion ion-clipboard mr-1"></i>
                                Attendance
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table" id="datatable">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $absent->employee->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{ \Auth::user()->dateFormat($absent->date) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $absent->status ? 'Present' : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Check In</th>
                                        <td>{{ $absent->check_in }}</td>
                                    </tr>
                                    <tr>
                                        <th>Check Out</th>
                                        <td>
                                            @if ($absent->check_out)
                                                {{ $absent->check_out }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Absent Spot</th>
                                        <td>{{ $absent->absent_spot }}</td>
                                    </tr>
                                    <tr>
                                        <th>Lat, Long</th>
                                        <td>{{ $absent->latitude }}, {{ $absent->longitude }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $absent->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Location</th>
                                        <td>
                                            <div style="width: 100%">
                                                <iframe width="100%" height="300" title="location"
                                                    src="https://maps.google.com/maps?q={{ $absent->latitude }},{{ $absent->longitude }}&hl=en&z=14&amp;output=embed">
                                                </iframe>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Photo</th>
                                        <td><img width="200"
                                                src="{{ asset('/storage/assets/absent/' . $absent->photo) }}"
                                                alt=""></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
        </div>
    </section>
@endsection

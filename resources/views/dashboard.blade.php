@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-b-3">Dashboard</h4>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-6">
                <ul class="breadcrumb ">
                    <li class="breadcrumb-item"><a style="color: #ffc107" href="/">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@stop

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $employees->count() }}</h3>

                        <p>Employee</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-users"></i>
                    </div>
                    <a href="{{ route('employee.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $absentTodays->count() }}</h3>

                        <p>Employees Present Today</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-business-time"></i>
                    </div>
                    <a href="{{ route('absent.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <!-- Main row -->
        {{-- <div class="row">
            <!-- Left col -->
            <section class="col-lg-12">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Attendance Chart -->
                <div class="card">
                    <div class="card-body">
                        <div id="chart" style="height: 300px"></div>
                    </div>
                </div>
                <!-- /.card -->
            </section>
            <!-- /.Left col -->
        </div> --}}
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "@chart('attendance_chart')",
            hooks: new ChartisanHooks()
                .colors(['#3490dc', '#e3342f', '#38c172'])
                .legend({
                    position: 'bottom'
                })
                .datasets(['bar', 'bar', {
                    type: 'line',
                    fill: false
                }])
                .tooltip()
        });
    </script>
@stop

@extends('adminlte::page')

@section('content')
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
                        <li class="breadcrumb-item"><a style="color: #ffc107"
                                href="{{ route('employee.index') }}">Employee</a>
                        </li>
                        <li class="breadcrumb-item active">Manage Employee</li>
                    </ul>
                </div>
                <div class="col-sm-6 float-sm-right text-right">
                    <a href="{{ route('employee.edit', \Illuminate\Support\Facades\Crypt::encrypt($employee->id)) }}"
                        data-toggle="tooltip" data-title="Edit Employee" class="btn btn-sm btn-warning"><i
                            class="fas fa-user-edit"></i></a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                @if ($employeePhoto)
                                    <img src="{{ asset('/storage/assets/user/' . $employeePhoto) }}" alt="avatar"
                                        class="rounded-circle" style="width: 40%; aspect-ratio: 1/1;">
                                @else
                                    <img src="{{ asset('/storage/assets/user/profile-picture.png') }}" alt="avatar"
                                        class="rounded-circle" style="width: 40%; aspect-ratio: 1/1;">
                                @endif

                                <h5 class="my-3 mb-0">{{ $employee->name }}</h5>
                                <p class="text-muted mb-0">#{{ $employee->employee_id }}</p>
                                <p class="text-muted mb-0">{{ $employee->division }}</p>
                                {{-- <div class="d-flex justify-content-center mb-2">
                                        <button type="button" class="btn btn-primary">Follow</button>
                                        <button type="button" class="btn btn-outline-primary ms-1">Message</button>
                                    </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5>Personal Detail</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Full Name</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $employee->name }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $employee->email }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Gender</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $employee->gender }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Phone</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $employee->phone }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Date Of Birthday</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ \Auth::user()->dateFormat($employee->dob) }}
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Address</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $employee->address }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Date Of Joining</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ \Auth::user()->dateFormat($employee->doj) }}
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Work From</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $employee->work_from }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
@endsection

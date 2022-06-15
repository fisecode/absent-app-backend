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
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    @if ($user->photo)
                                        <img src="{{ asset('/storage/assets/user/' . $user->photo) }}" alt="avatar"
                                            class="rounded-circle" width="200" height="200">
                                    @else
                                        <img src="{{ asset('/storage/assets/user/profile-picture.png') }}" alt="avatar"
                                            class="rounded-circle" width="200" height="200">
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
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ old('name', $employee->name) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" name="email"
                                                    value="{{ old('email', $employee->email) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="name">Gender</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ old('name', $employee->name) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control" name="phone"
                                                    value="{{ old('phone', $employee->phone) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label>Date:</label>
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#reservationdate" />
                                                <div class="input-group-append" data-target="#reservationdate"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Date and time -->
                                        <div class="form-group">
                                            <label>Date and time:</label>
                                            <div class="input-group date" id="reservationdatetime"
                                                data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#reservationdatetime" />
                                                <div class="input-group-append" data-target="#reservationdatetime"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Date range -->
                                        <div class="form-group">
                                            <label>Date range:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control float-right" id="reservation">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                        <div class="col-sm-3">
                                            <p class="mb-0">Date Of Birthday</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ \Auth::user()->dateFormat($employee->dob) }}
                                            </p>
                                        </div>
                                    </div>
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

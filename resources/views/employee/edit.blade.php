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
                                @if ($user->photo)
                                    <img src="{{ asset('/storage/assets/user/' . $user->photo) }}" alt="avatar"
                                        class="rounded-circle" style="width: 40%; aspect-ratio: 1/1;">
                                @else
                                    <img src="{{ asset('/storage/assets/user/profile-picture.png') }}" alt="avatar"
                                        class="rounded-circle" style="width: 40%; aspect-ratio: 1/1;">
                                @endif
                                <div class="form-group mt-3">
                                    <label for="photo">Change Photo</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" accept="image/*"
                                                required>
                                            <label class="custom-file-label" for="photo">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5>Personal Detail</h5>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', $employee->name) }}" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ old('phone', $employee->phone) }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="dob">Date of Birth</label>
                                        <input type="text" id="datepickerdob" class="form-control datetimepicker-input"
                                            data-toggle="datetimepicker" data-target="#datepickerdob"
                                            value="{{ old('dob', $employee->dob) }}" name="dob" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="gender">Gender</label>
                                        <div class="d-flex">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-warning"
                                                    type="radio" id="g_male" name="gender" value="Male"
                                                    {{ $employee->gender == 'Male' ? 'checked' : '' }}>
                                                <label for="g_male" class="custom-control-label">Male</label>
                                            </div>
                                            <div class="custom-control ml-3 custom-radio">
                                                <input class="custom-control-input custom-control-input-warning"
                                                    type="radio" id="g_female" name="gender" value="Female"
                                                    {{ $employee->gender == 'Female' ? 'checked' : '' }}>
                                                <label for="g_female" class="custom-control-label">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label for="address">Address</label>
                                        <textarea class="form-control" rows="3" name="address">{{ old('address', $employee->address) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <h5>Company Detail</h5>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="employe_id">Employee ID</label>
                                        <input type="text" class="form-control" name="employe_id"
                                            value="{{ old('employe_id', $employee->employee_id) }}" disabled>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="doj">Date of Joining</label>
                                        <input type="text" id="datepickerdoj" class="form-control datetimepicker-input"
                                            data-toggle="datetimepicker" data-target="#datepickerdoj"
                                            value="{{ old('doj', $employee->doj) }}" name="doj" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="division">Division</label>
                                        <select class="form-control select2 select2-warning"
                                            data-dropdown-css-class="select2-warning" style="width: 100%;">
                                            <option selected="selected">Alabama</option>
                                            <option>Comic</option>
                                            <option>Compositing</option>
                                            <option>Motion Graphic</option>
                                            <option>Painting</option>
                                        </select>
                                        <input type="text" class="form-control" name="division"
                                            value="{{ old('division', $employee->division) }}" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="work_from">Work From</label>
                                        <input type="text" class="form-control" name="work_from"
                                            value="{{ old('work_from', $employee->work_from) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
@endsection

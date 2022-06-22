@extends('adminlte::page')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-b-3">User Profile</h4>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ul class="breadcrumb ">
                        <li class="breadcrumb-item"><a style="color: #ffc107" href="/">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
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

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12">
                <form action="{{ route('updateProfile', Auth::user()->id) }}" method="put"
                    enctype="multipart/form-data">
                    @csrf
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
                                                <input type="file" class="custom-file-input" name="image"
                                                    accept="image/*">
                                                <label class="custom-file-label" for="photo">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Personal Detail</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', $user->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email', $user->email) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 float-sm-right text-right">
                                <input type="submit" value="Save Change" class="btn btn-warning" data-toggle="tooltip"
                                    data-title="Save Change">
                            </div>

                        </div>

                    </div>
                </form>
                <form action="{{ route('updatePasswordProfile') }}" method="put" enctype="multipart/form-data">
                    @csrf
                    <div class="row flex-row-reverse">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Change Password</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="current_password">Current Password</label>
                                            <input type="password" name="current_password" class="form-control"
                                                placeholder="Enter Current Password">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="new_password">New Password</label>
                                            <input type="password" name="new_password" class="form-control"
                                                placeholder="Enter New Password">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="Confirm Password">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Enter Confirm Password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 float-sm-right text-right">
                        <input type="submit" value="Save Change" class="btn btn-warning" data-toggle="tooltip"
                            data-title="Save Change">
                    </div>
                </form>
            </section>
        </div>
    </section>
@endsection

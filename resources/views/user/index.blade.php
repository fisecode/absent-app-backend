@extends('adminlte::page')

@section('content')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-b-3">Manage Users</h4>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ul class="breadcrumb ">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ul>
                </div>
                <div class="col-sm-6 float-sm-right text-right">
                    <a href="#" data-url="{{ route('user.create') }}" data-ajax-popup="true" data-toggle="tooltip"
                        data-title="Create New User" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Add
                        User</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
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

        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row">
                    @foreach ($users as $user)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-body pt-0 mt-2">
                                    <div class="row">
                                        <div class="col-3 text-center">
                                            @if ($user->photo)
                                                <img src="{{ asset('/storage/assets/user/' . $user->photo) }}"
                                                    alt="user-avatar" class="img-circle img-fluid">
                                            @else
                                                <img src="{{ asset('/storage/assets/user/default-profile.png') }}"
                                                    alt="user-avatar" class="img-circle img-fluid">
                                            @endif
                                        </div>
                                        <div class="col-9">
                                            <h5 class="lead"><b>{{ $user->name }}</b></h5>
                                            <p class="text-muted text-sm">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <a href="#" data-url="{{ route('user.edit', $user->id) }}"
                                            class="btn btn-sm btn-warning" data-ajax-popup="true" data-toggle="tooltip"
                                            data-title="Edit User" data-original-title="Edit User"><i
                                                class="fas fa-user-edit"></i></a>
                                        <a href="#" data-url="{{ route('show.password', $user->id) }}"
                                            class="btn btn-sm btn-secondary" data-ajax-popup="true" data-toggle="tooltip"
                                            data-title="Change Password" data-original-title="Change Password"><i
                                                class="fas fa-key"></i></a>
                                        <a href="#" data-url="{{ route('delete', $user->id) }}"
                                            class="btn btn-sm btn-outline-light" data-ajax-popup="true"
                                            data-toggle="tooltip" data-title="Delete User"
                                            data-original-title="Delete User"><i class="fas fa-user-minus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <nav aria-label="Users Page Navigation">
                    <ul class="pagination justify-content-center m-0">
                        {{ $users->links() }}
                    </ul>
                </nav>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->

        {{-- <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div> --}}
    </section>
    <!-- /.content -->
@endsection

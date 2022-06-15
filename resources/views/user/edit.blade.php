<form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="form-group">
        <div class="mb-2" style="width:30%">

            @if ($user->photo)
                <img src="{{ asset('/storage/assets/user/' . $user->photo) }}" alt="user-avatar" class="rounded-circle"
                    style="width: 100%; aspect-ratio: 1/1;">
            @endif
        </div>
        <label for="">Photo</label>
        <input type="file" name="image" class="form-control-file">
    </div>
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <input type="submit" value="Update" class="btn btn-primary">
    </div>
</form>

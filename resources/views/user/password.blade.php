<form action="{{ route('update.password', $user->id) }}" method="post" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="form-group">
        <label for="">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter New Password">
    </div>
    <div class="form-group">
        <label for="">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Enter Confirm Password">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <input type="submit" value="Update" class="btn btn-warning">
    </div>
</form>

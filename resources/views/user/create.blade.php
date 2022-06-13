<form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" placeholder="Enter name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" placeholder="Enter email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password" required>
    </div>
    <div class="form-group">
        <label for="">Photo</label>
        <input type="file" name="image" class="form-control-file">
    </div>
    <div class="form-group">
        <label for="photo">Photo</label>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="photo" accept="image/*" required>
                <label class="custom-file-label" for="photo">Choose file</label>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <input type="submit" value="Create" class="btn btn-primary">
    </div>
</form>

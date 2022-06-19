<form action="{{ route('leavetype.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" placeholder="Enter Leave Name" required>
    </div>
    <div class="form-group">
        <label for="days">Days Per Year</label>
        <input type="text" class="form-control" name="days" placeholder="Enter Days / Year">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <input type="submit" value="Create" class="btn btn-warning">
    </div>
</form>

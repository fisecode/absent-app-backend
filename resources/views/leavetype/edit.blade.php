<form action="{{ route('leavetype.update', $leaveType->id) }}" method="post" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $leaveType->name) }}">
    </div>
    <div class="form-group">
        <label for="days">Days Per Year</label>
        <input type="text" name="days" class="form-control" value="{{ old('days', $leaveType->days) }}">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        <input type="submit" value="Update" class="btn btn-warning">
    </div>
</form>

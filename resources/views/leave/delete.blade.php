<form action="{{ route('leave.destroy', $leave->id) }}" method="post">
    @csrf @method('DELETE')
    <div class="modal-body">
        <h5 class="text-center">Are you sure you want to delete leave for {{ $leave->employee->name }}?
        </h5>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-light">Yes, Delete</button>
    </div>
</form>

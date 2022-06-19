<form action="{{ route('absentspot.destroy', $absentSpot->id) }}" method="post">
    <div class="modal-body">
        @csrf
        @method('DELETE')
        <h5 class="text-center">Are you sure you want to delete absent spot for {{ $absentSpot->employee->name }} ?
        </h5>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-light">Yes, Delete</button>
    </div>
</form>

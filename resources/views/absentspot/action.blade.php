<form action="{{ route('absentspot.approval', $absentSpot->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card-body p-0">
        <table class="table">
            <tr role="row">
                <th>Employee</th>
                <td>{{ $absentSpot->employee->name }}</td>
            </tr>
            <tr>
                <th>Spot Name</th>
                <td>{{ $absentSpot->name_spot }}</td>
            </tr>
            <tr>
                <th>Latitude</th>
                <td>{{ $absentSpot->latitude }}</td>
            </tr>
            <tr>
                <th>Longitude</th>
                <td>{{ $absentSpot->longitude }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $absentSpot->address }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $absentSpot->status }}</td>
            </tr>
            <input type="hidden" value="{{ $absentSpot->id }}" name="absentspot_id">
        </table>
    </div>
    <div class="modal-footer pr-0">
        <input type="submit" class="btn btn-success" value="Approval" name="status">
        <input type="submit" class="btn btn-danger" value="Reject" name="status">
    </div>
</form>

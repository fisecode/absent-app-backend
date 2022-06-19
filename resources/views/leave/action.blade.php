<form action="{{ route('leave.approval', $leave->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card-body p-0">
        <table class="table">
            <tr role="row">
                <th>Employee</th>
                <td>{{ $leave->employee->name }}</td>
            </tr>
            <tr>
                <th>Leave Type</th>
                <td>{{ $leave->leaveType->name }}</td>
            </tr>
            <tr>
                <th>Applied On</th>
                <td>{{ $leave->applied_on }}</td>
            </tr>
            <tr>
                <th>Start Date</th>
                <td>{{ $leave->start_date }}</td>
            </tr>
            <tr>
                <th>End Date</th>
                <td>{{ $leave->end_date }}</td>
            </tr>
            <tr>
                <th>Leave Reason</th>
                <td>{{ $leave->leave_reason }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $leave->status }}</td>
            </tr>
            <input type="hidden" value="{{ $leave->id }}" name="leave_id">
        </table>
    </div>
    <div class="modal-footer pr-0">
        <input type="submit" class="btn btn-success" value="Approved" name="status">
        <input type="submit" class="btn btn-danger" value="Reject" name="status">
    </div>
</form>

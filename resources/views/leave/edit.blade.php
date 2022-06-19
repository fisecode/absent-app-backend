<form action="{{ route('leave.update', $leave->id) }}" method="post" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="card-body p-0">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="employee">Employee</label>
                    <select class="form-control select2" name="employee_id" data-dropdown-css-class="select2-warning"
                        style="width: 100%;" required>
                        <option value="{{ $leave->employee->id }}" selected="selected">
                            {{ $leave->employee->name }}
                        </option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="leave_type">Leave Type</label>
                    <select class="form-control select2" name="leave_type_id" data-dropdown-css-class="select2-warning"
                        style="width: 100%;" required>
                        <option value="{{ $leave->leaveType->id }}" selected="selected">
                            {{ $leave->leaveType->name }}
                        </option>
                        @foreach ($leaveTypes as $leaveType)
                            <option value="{{ $leaveType->id }}">{{ $leaveType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="text" id="datepicker1" class="form-control datetimepicker-input"
                        data-toggle="datetimepicker" data-target="#datepicker1"
                        value="{{ old('start_date', $leave->start_date) }}" name="start_date" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="text" id="datepicker2" class="form-control datetimepicker-input"
                        data-toggle="datetimepicker" data-target="#datepicker2" value="{{ $leave->end_date }}"
                        name="end_date" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="leave_reason">Leave Reason</label>
                    <textarea class="form-control" rows="3" name="leave_reason">{{ old('leave_reason', $leave->leave_reason) }}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="" class="form-control select2">
                        <option value="">{{ __('Select Status') }}</option>
                        <option value="Pending" @if ($leave->status == 'Pending') selected="" @endif>
                            Pending</option>
                        <option value="Approved" @if ($leave->status == 'Approved') selected="" @endif>
                            Approved</option>
                        <option value="Reject" @if ($leave->status == 'Reject') selected="" @endif>
                            Reject
                        </option>
                    </select>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer pr-0">
        <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('Cancel') }}</button>
        {{ Form::submit(__('Update'), ['class' => 'btn btn-warning']) }}
    </div>
    {{ Form::close() }}
</form>

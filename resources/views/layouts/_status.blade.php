@if ($status == 'Pending')
    <div class="badge badge-pill badge-warning p-2 px-3 text-white">{{ $status }}</div>
@elseif($status == 'Approve')
    <div class="badge badge-pill badge-success p-2 px-3">{{ $status }}</div>
@else($status== "Reject")
    <div class="badge badge-pill badge-danger p-2 px-3">{{ $status }}</div>
@endif

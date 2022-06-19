@if ($action_url)
    <a href="#" data-url="{{ $action_url }}" class="btn btn-sm btn-warning text-white" data-ajax-popup="true"
        data-toggle="tooltip" data-title="Approval" data-original-title="Approval"><i class="fas fa-play"></i></a>
@endif

@if ($edit)
    <a href="{{ $edit }}" class="btn btn-sm btn-warning text-white" data-toggle="tooltip" data-title="Edit"><i
            class="fas fa-pen"></i></a>
@endif

@if ($edit_url)
    <a href="#" data-url="{{ $edit_url }}" class="btn btn-sm btn-warning" data-ajax-popup="true"
        data-toggle="tooltip" data-title="Delete" data-original-title="Delete"><i class="fas fa-trash"></i></a>
@endif
@if ($delete_url)
    <a href="#" data-url="{{ $delete_url }}" class="btn btn-sm btn-outline-light" data-ajax-popup="true"
        data-toggle="tooltip" data-title="Delete" data-original-title="Delete"><i class="fas fa-trash"></i></a>
@endif

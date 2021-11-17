<div class="table-actions d-flex align-items-center justify-content-end">
    @if (!$feedback->is_read)
        <button data-link="{{route('admin.feedbacks.read', $feedback)}}" type="button" class="btn btn-warning btn-sm mr-1 read-feedback">Mark as read</button>
    @endif
    <a href="{{route('admin.feedbacks.show', $feedback)}}" class="btn btn-primary btn-sm mr-1">Show</a>
    <button data-link="{{route('admin.feedbacks.destroy', $feedback)}}" type="button" class="delete-resource btn btn-danger btn-sm">Delete</button>
</div>
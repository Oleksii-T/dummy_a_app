<div class="table-actions d-flex align-items-center">
    <a href="{{route('admin.orders.edit', $order)}}" class="btn btn-primary btn-sm mr-1">Edit</a>
    <button data-link="{{route('admin.orders.destroy', $order)}}" type="button" class="delete-resource btn btn-danger btn-sm">Delete</button>
</div>
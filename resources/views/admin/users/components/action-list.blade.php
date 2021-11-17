<div class="table-actions d-flex align-items-center">
    <a href="{{route('admin.users.edit', $user)}}" class="btn btn-primary btn-sm mr-1">Edit</a>
    <button data-link="{{route('admin.users.destroy', $user)}}" type="button" class="delete-resource btn btn-danger btn-sm">Delete</button>
</div>
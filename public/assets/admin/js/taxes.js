$(document).ready(function () {
    var $ = jQuery.noConflict();

	let table = $('#taxes-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: window.location.href,
		columns: [
			{ data: 'id', name: 'id' },
			{ data: 'title', name: 'title' },
			{ data: 'percentage', name: 'percentage' },
			{ data: 'is_inclusive', name: 'is_inclusive' },
			{ data: 'is_active', name: 'is_active' },
			{ data: 'action', name: 'action', orderable: false, searchable: false }
		],
	})

  	$(document).on('click', '#taxes-table .delete-resource', function (e) {
		e.preventDefault();
		deleteResource(table, $(this).data('link'));
	});
})
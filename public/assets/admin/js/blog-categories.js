$(document).ready(function () {
    var $ = jQuery.noConflict();

	let table = $('#blog-categories-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: window.location.href,
		columns: [
			{ data: 'id', name: 'id' },
			{ data: 'name', name: 'name' },
			{ data: 'action', name: 'action', orderable: false, searchable: false }
		],
	})

  	$(document).on('click', '#blog-categories-table .delete-resource', function (e) {
		e.preventDefault();
		deleteResource(table, $(this).data('link'));
	});
})
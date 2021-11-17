$(document).ready(function () {
    var $ = jQuery.noConflict();

	let table = $('#orders-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: window.location.href,
		columns: [
			{ data: 'id', name: 'id' },
			{ data: 'user', name: 'user' },
			{ data: 'number', name: 'number' },
			{ data: 'amount', name: 'amount' },
			{ data: 'status', name: 'status' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'action', name: 'action', orderable: false, searchable: false }
		],
	})

  	$(document).on('click', '#orders-table .delete-resource', function (e) {
		e.preventDefault();
		deleteResource(table, $(this).data('link'));
	});
})
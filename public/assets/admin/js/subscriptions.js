$(document).ready(function () {
    var $ = jQuery.noConflict();

	let table = $('#subscriptions-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: window.location.href,
		columns: [
			{ data: 'id', name: 'id' },
			{ data: 'user', name: 'user' },
			{ data: 'plan', name: 'plan' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'expire_at', name: 'expire_at' },
			{ data: 'action', name: 'action', orderable: false, searchable: false }
		],
	})

  	$(document).on('click', '#subscriptions-table .delete-resource', function (e) {
		e.preventDefault();
		deleteResource(table, $(this).data('link'));
	});
})
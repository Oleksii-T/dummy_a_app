$(document).ready(function () {
    var $ = jQuery.noConflict();

	let table = $('#promocodes-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: {
			url: window.location.href,
			data: function (filter) {
				filter.type = $('.table-filter[name=type]').val();
				filter.status = $('.table-filter[name=status]').val();
			}
		},
		columns: [
			{ data: 'id', name: 'id' },
			{ data: 'code', name: 'code' },
			{ data: 'type', name: 'type' },
			{ data: 'discount', name: 'discount' },
			{ data: 'status', name: 'status', orderable: false, searchable: false },
			{ data: 'action', name: 'action', orderable: false, searchable: false }
		]
	});
	
	$('.table-filter').change(function() {
		table.draw();
	});

  	$(document).on('click', '#promocodes-table .delete-resource', function (e) {
		e.preventDefault();
		deleteResource(table, $(this).data('link'));
	});
})
$(document).ready(function () {
    var $ = jQuery.noConflict();

	let table = $('#pages-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: {
			url: window.location.href,
			data: function (filter) {
				filter.status = $('.table-filter[name=status]').val();
			}
		},
		columns: [
			{ data: 'id', name: 'id' },
			{ data: 'title', name: 'title' },
			{ data: 'url', name: 'url' },
			{ data: 'status', name: 'status' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'action', name: 'action', orderable: false, searchable: false }
		],
	})
	
	$('.table-filter').change(function() {
		table.draw();
	});

  	$(document).on('click', '#pages-table .delete-resource', function (e) {
		e.preventDefault();
		deleteResource(table, $(this).data('link'));
	});
})
$(document).ready(function () {
    var $ = jQuery.noConflict();

	let table = $('#blogs-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: {
			url: window.location.href,
			data: function (filter) {
				filter.category = $('.table-filter[name=category]').val();
			}
		},
		columns: [
			{ data: 'id', name: 'id' },
			{ data: 'title', name: 'title' },
			{ data: 'content', name: 'content' },
			{ data: 'action', name: 'action', orderable: false, searchable: false }
		],
	})
	
	$('.table-filter').change(function() {
		table.draw();
	});

  	$(document).on('click', '#blogs-table .delete-resource', function (e) {
		e.preventDefault();
		deleteResource(table, $(this).data('link'));
	});
})
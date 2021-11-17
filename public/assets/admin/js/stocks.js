$(document).ready(function () {
    var $ = jQuery.noConflict();

	let table = $('#stocks-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: {
			url: window.location.href,
			data: function (filter) {
				filter.type = $('.table-filter[name=type]').val();
			}
		},
		columns: [
			{ data: 'date', name: 'date' },
			{ data: 'open', name: 'open' },
			{ data: 'high', name: 'high' },
			{ data: 'low', name: 'low' },
			{ data: 'close', name: 'close' },
			{ data: 'adj_close', name: 'adj_close' },
			{ data: 'volume', name: 'volume' },
		],
	})

	$('.table-filter').change(function() {
		table.draw();
	});
})
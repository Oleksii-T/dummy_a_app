$(document).ready(function () {
    var $ = jQuery.noConflict();

	let table = $('#faqs-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: window.location.href,
		columns: [
			{ data: 'id', name: 'id' },
			{ data: 'question', name: 'question' },
			{ data: 'answer', name: 'answer' },
			{ data: 'action', name: 'action', orderable: false, searchable: false }
		],
	})

  	$(document).on('click', '#faqs-table .delete-resource', function (e) {
		e.preventDefault();
		deleteResource(table, $(this).data('link'));
	});
})
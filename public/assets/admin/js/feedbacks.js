$(document).ready(function () {
    var $ = jQuery.noConflict();

	let table = $('#feedbacks-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: {
			url: window.location.href,
			data: function (filter) {
				filter.is_read = $('.table-filter[name=is_read]').val();
			}
		},
		columns: [
			{ data: 'id', name: 'id' },
			{ data: 'user', name: 'user' },
			{ data: 'email', name: 'email' },
			{ data: 'content', name: 'content' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'action', name: 'action', orderable: false, searchable: false }
		],
		'createdRow': function (row, data, dataIndex) {
			if (data.is_read == '1') {
				$(row).addClass('readed_row');
			}
		}
	})
	
	$('.table-filter').change(function() {
		table.draw();
	});

  	$(document).on('click', '#feedbacks-table .delete-resource', function (e) {
		e.preventDefault();
		deleteResource(table, $(this).data('link'));
	});

  	$(document).on('click', '.read-feedback', function (e) {
		e.preventDefault();
		let _this = $(this);
		$.ajax({
			url: _this.data('link'),
			data: {
				_token: $("[name='csrf-token']").attr("content")
			},
			type: 'post',
			success: (response)=>{
				if (response.success) {
					swal.fire("Success!", response.message, 'success');
					table.draw();
				} else {
					swal.fire("Error!", response.message, 'error');
				}
			},
			error: function(response) {
				swal.fire("Error!", response.message, 'error');
			}
		});
	});
})
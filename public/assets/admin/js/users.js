$(document).ready(function () {
    var $ = jQuery.noConflict();

	let table = $('#users-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: {
			url: '/admin/users/data-table',
			data: function (filter) {
				filter.status = $('.table-filter[name=status]').val();
			}
		},
		columns: [
			{ data: 'id', name: 'id' },
			{ data: 'full_name', name: 'full_name' },
			{ data: 'orders', name: 'orders' },
			{ data: 'status', name: 'status', orderable: false, searchable: false },
			{ data: 'action', name: 'action', orderable: false, searchable: false }
		],
	})
	
	$('.table-filter').change(function() {
		table.draw();
	});

  	$(document).on('click', '#users-table .delete-resource', function (e) {
		e.preventDefault();
		deleteResource(table, $(this).data('link'));
	});

    //dispaly image preview when uploading image
    $('.custom-file input').change(function(e){
        let reader = new FileReader();
        let container = $(this).closest('.form-group');
		
        container.find('.custom-file-delete').removeClass('d-none');
    
        reader.onload = (e) => {
            $('.custom-file-preview img').attr('src', e.target.result);
        };
    
        reader.readAsDataURL(e.target.files[0]);
        container.find('.custom-file-label').text(e.target.files[0].name);
    })

	// clear uploaded image from form input
	$('.custom-file-delete').click(function(){
		$(this).addClass('d-none');
		let container = $(this).closest('.form-group');
		container.find('input[type=file]').val('');
		container.find('label.custom-file-label').text('');
		container.find('.input-group-append').addClass('d-none');
		container.find('input[name=image_deleted]').val('1');
		$('.custom-file-preview img').attr('src', '/assets/admin/img/empty-image.png');
	})

	table = $('#users-subscriptions-table').DataTable({
		//processing: true,
		order: [[ 0, "desc" ]],
		serverSide: true,
		ajax: window.location.href,
		columns: [
			{ data: 'title', name: 'title' },
			{ data: 'period', name: 'period' },
			{ data: 'interval', name: 'interval' },
			{ data: 'status', name: 'interval' },
			{ data: 'price', name: 'prive'},
		],
	})
})
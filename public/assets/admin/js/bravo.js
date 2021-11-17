$(document).ready(function ($) {
    // general logic of ajax form submit
	$('form.general-ajax-submit').on('submit', function(e){
		e.preventDefault();
        showLoading();
		let form = $(this);
		$('.input-error').empty();

		$.ajax({
			url: form.attr('action'),
			type: form.attr('method'),
			data: form.serialize(),
			success: (response)=>{
				showServerSuccess(response);
			},
			error: function(response) {
                swal.close();
				showServerError(response);
			}
		});
	})
    // general logic of ajax form submit with files using FormData object
	$('form.general-ajax-submit-with-files').submit(function(e){
		e.preventDefault();
        showLoading();
		let form = $(this);
		$('.input-error').empty();
        var formData = new FormData(this);

		$.ajax({
			url: form.attr('action'),
			type: form.attr('method'),
			data: formData,
            cache: false,
            contentType: false,
            processData: false,
			success: (response)=>{
				showServerSuccess(response);
			},
			error: function(response) {
                swal.close();
				showServerError(response);
			}
		});
	})

    //dispaly image preview when uploading image
    $('.general-file-input-with-preview .custom-file input').change(function(e){
        let reader = new FileReader();
        let container = $(this).closest('.form-group');
        let preview = $('img[data-preview='+$(this).data('preview')+']');
		
        container.find('.custom-file-delete').removeClass('d-none');
    
        reader.onload = (e) => {
            preview.attr('src', e.target.result);
        };
    
        reader.readAsDataURL(e.target.files[0]);
        container.find('.custom-file-label').text(e.target.files[0].name);
    })

	// clear uploaded image from form input
	$('.general-file-input-with-preview .custom-file-delete').click(function(){
		$(this).addClass('d-none');
		let container = $(this).closest('.form-group');
		container.find('input[type=file]').val('');
		container.find('label.custom-file-label').text('');
		container.find('.input-group-append').addClass('d-none');
		container.find('input[name=image_deleted]').val('1');
		container.find('.custom-file-preview').empty();
		container.find('.custom-file-preview').append('<img src="">');
	})

    // automatick slug generator
    let slugChanged = false;
    $('.generate-slug').keyup(function(){
        if (slugChanged) {
            return;
        }
        let val = $(this).val().replace(' ', '-').replace(/[^\w-]/g, '').toLowerCase();
        $('input[name=slug]').val(val);
    })
    $('input[name=slug]').keyup(function(){
        slugChanged = true;
    })

    //
})

// flash notification
const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000,
	timerProgressBar: true,
	didOpen: (toast) => {
		toast.addEventListener('mouseenter', Swal.stopTimer)
		toast.addEventListener('mouseleave', Swal.resumeTimer)
	}
});

//general file upload
function fileUpload(file, url="/api/v1/upload") {
    data = new FormData();
    data.append("file", file);
    let req = $.ajax({
        data: data,
        type: "POST",
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Authorization": "Bearer " + $('meta[name=api_token]').attr('content')
        }
    });

    if (req.status == 200 && req.responseJSON.success == true) {
        return req.responseJSON.data;
    }
    return null;
}

//delete resource from datatable
function deleteResource(dataTable, url) {
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            jQuery.ajax({
                url: url,
                type: 'delete',
                data: {
                    _token: jQuery("[name='csrf-token']").attr("content")
                },
                success: (response)=>{
                    if (response.success) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        dataTable.draw();
                    } else {
                        swal.fire("Error!", response.message, 'error');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    swal.fire("Error!", '', 'error');
                }
            });
        }
    });
}

// general error logic, after ajax form submit been processed
function showServerError(response) {
    if (response.status == 422) {
        for (const [field, value] of Object.entries(response.responseJSON.errors)) {
            let errorText = '';
            let errorElement = $(`.input-error[data-input=${field}]`);
            errorElement = errorElement.length ? errorElement : $(`.input-error[data-input="${field}[]"]`);
            errorElement = errorElement.length ? errorElement : $(`[name=${field}]`).closest('.form-group').find('.input-error');
            errorElement = errorElement.length ? errorElement : $(`[name="${field}[]"]`).closest('.form-group').find('.input-error');
            for (const [key, error] of Object.entries(value)) {
                errorText = errorText ? errorText+'<br>'+error : error;
            }
            errorElement.html(errorText);
        }
    } else {
        swal.fire('Error!', 'Server error', 'error');
    }
}

// general success logic, after ajax form submit been processed
function showServerSuccess(response) {
    if (response.success) {
        swal.fire("Success!", response.message, 'success').then((result) => {
            window.location.href = response.redirect;
        });
    } else {
        swal.fire("Error!", response.message, 'error');
    }
}

//show loading unclosable popup
function showLoading(text='Request processing...') {
    swal.fire({
        title: 'Wait!',
        text: text,
        didOpen: () => {
            swal.showLoading();
        },
        showConfirmButton: false,
        allowOutsideClick: false
    });
}
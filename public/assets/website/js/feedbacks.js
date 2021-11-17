$(document).ready(function () {
	$('form.contact-form').submit(function(e){
		e.preventDefault();
		let form = $(this);
		$('.input-error').empty();

		$.ajax({
			url: form.attr('action'),
			type: form.attr('method'),
			data: form.serialize(),
			success: (response)=>{
				if (response.success) {
					swal.fire('Success!', response.message, 'success');
					$('[name=content]').val('');
				} else {
					swal.fire('Error!', response.message, 'error');
				}
			},
			error: function(response) {
				if (response.status == 422) {
					let responseData = JSON.parse(response.responseText).errors;
					for (const [field, value] of Object.entries(responseData)) {
						let errorText = '';
						let errorElement = $(`[name=${field}]`).closest('.input-group').find('.input-error');
						for (const [key, error] of Object.entries(value)) {
							errorText = errorText ? errorText+'<br>'+error : error;
						}
						errorElement.html(errorText);
					}
				} else {
					swal.fire('Error!', 'Server error', 'error');
				}
			}
		});
	})
})
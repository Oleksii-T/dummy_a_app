$(function () {

    $('#profile-update').on('submit', function (e) {
        e.preventDefault();
        let $form = $(this);

        $.ajax({
            url : $form.attr('action'),
            type : $form.attr('method'),
            data : $form.serialize(),
            beforeSend: function () {
                $('.invalid-feedback').hide();
            },
            success : function (response) {
                if (response.success) {
                    swal.fire({
                        title : 'Success!',
                        text : response.message,
                        icon : 'success',
                        confirmButtonColor : '#0D74EE'
                    });
                } else {
                    swal.fire({
                        title : 'Error!',
                        icon : 'error',
                        confirmButtonColor : '#0D74EE'
                    });
                }
            },
            error : function (response) {
                if (response.status === 422) {
                    swal.fire({
                        title : 'Error!',
                        text : 'Validation error!',
                        icon : 'error',
                        confirmButtonColor : '#0D74EE'
                    });
                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        $('.invalid-feedback[data-field="' + field + '"]').text(value[0]).show();
                    });
                } else {
                    swal.fire({
                        title : 'Error!',
                        icon : 'error',
                        confirmButtonColor : '#0D74EE'
                    });
                }
            },
        })
    });
});

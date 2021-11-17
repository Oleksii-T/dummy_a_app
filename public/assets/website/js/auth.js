$(function () {

    $('#sign-up').on('submit', function (e) {
        e.preventDefault();
        let $form = $(this);

        $.ajax({
            url : $form.attr('action'),
            type : $form.attr('method'),
            data : $form.serialize(),
            headers   : {
                Accept: 'application/json',
            },
            beforeSend: function () {
                $('.invalid-feedback').hide();
            },
            success : function (response) {
                swal.fire({
                    title : 'Success!',
                    text : '',
                    icon : 'success',
                    confirmButtonColor : '#0D74EE'
                }).then( ()=>{
                    window.location = $form.data('home');
                });
            },
            error : function (response) {
                if (response.status === 422) {
                    swal.fire({
                        title : 'Error!',
                        text : 'Validation error!',
                        icon : 'error',
                        confirmButtonColor : '#0D74EE'
                    });
                    console.log(response);
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

    $('.input-button').on('click', function () {
        let $parent = $(this).parent().find('input');
        if ($parent.attr('type') === 'password'){
            $parent.attr('type', 'text');
        }
        else{
            $parent.attr('type', 'password');
        }
    });
});

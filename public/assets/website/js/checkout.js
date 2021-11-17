$(document).ready(function () {
    var $ = jQuery.noConflict();
    let stripe = Stripe(publishableKey);
    //

    function displayError(event) {
        let displayError = document.getElementById('card-element-errors');

        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    }

    form.addEventListener('submit', function (ev) {
        ev.preventDefault();
        let paymentMethod = $('input[name="payment_method"]:checked').val();

        if(paymentMethod == 'paypal') {
            paypalSubscribe();
        }

        if (paymentMethod === 'card') {
            createPaymentMethod(card);
        }

        if (paymentMethod === 'default' && paymentMethodId) {
            createSubscription(paymentMethodId);
        }
    });

    function paypalSubscribe() {
        loading('Subscription processing...');
		$.ajax({
			url: '/api/v1/paypal',
			type: 'post',
			data: {
                api_token: api_token,
                subscriptionPlanId: subscriptionPlanId,
                promocode: $('[name=promocode]').val()
            },
			success: (response)=>{
                swal.close();
                if (response.success && response.link) {
                    window.location = response.link;
                } else {
                    showServerError(response);
                }
			},
			error: function(response) {
                swal.close();
				showServerError(response);
			}
		});
    }

    function createPaymentMethod(card) {
        //
    }

    function createSubscription(paymentMethodId) {
        //
    }


    $('.enter-promocode').click(function () {
        let plan = $(this).data('plan');
        Swal.fire({
            title: 'Enter promocode',
            input: 'text',
            inputPlaceholder: 'xxxxxxxxx',
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'Please enter promocode!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                loading('Promocode activation...');

                $.ajax({
                    url: `/checkout/${plan}/promocode/${result.value}`,
                    type: 'get',
                    success: (response) => {
                        if (response.success) {
                            swal.close();
                            $('.promocode-label').removeClass('d-none');
                            $('.promocode-label').find('[name=promocode]').val(response.id);
                            $('.promocode-discount').text(response.discountReadable);
                            $('.total-price').text(response.priceReadable);
                        } else {
                            swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function (response) {
                        swal.fire('Error!', 'Server error', 'error');
                    }
                });
            }
        });
    });
});
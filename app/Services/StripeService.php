<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Tax;
use App\Models\User;

class StripeService
{
    private $stripe;

    /**
     * StripeService constructor.
     * @throws \Exception
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function __construct()
    {
        if (!Setting::get('stripe_secret_key')) {
            throw new \Exception('You need to configure the stripe');
        }

        $this->stripe = new \Stripe\StripeClient(Setting::get('stripe_secret_key'));

        if (!Setting::get('stripe_product')) {
            Setting::set('stripe_product', $this->createProduct()->id);
        }
    }

    /**
     * @param User $user
     * @return mixed
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createCustomer(User $user)
    {
        if (!$user->stripe_id) {
            $customer = $this->stripe->customers->create([
                'description' => 'User #' . $user->id
            ]);

            $user->update([
                'stripe_id' => $customer->id
            ]);
        }

        return $user;
    }

    /**
     * @param User $user
     * @param $paymentMethodId
     * @return bool
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function updateDefaultPaymentMethod(User $user, $paymentMethodId, $save)
    {
        if (!$user->stripe_id) {
            $user = $this->createCustomer($user);
        }

        if ($save) {
            $user->update([
                'stripe_default_payment_id' => $paymentMethodId
            ]);
        }

        $this->stripe->customers->update($user->stripe_id, [
            'invoice_settings' => [
                'default_payment_method' => $paymentMethodId
            ]
        ]);

        return true;
    }

    /**
     * @param $paymentMethodId
     * @param bool $customerId
     * @return \Stripe\PaymentMethod
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getPaymentMethod($paymentMethodId, $customerId = false)
    {
        $payment_method = $this->stripe->paymentMethods->retrieve($paymentMethodId);
        if ($customerId) {
            $payment_method->attach([
                'customer' => $customerId
            ]);
        }

        return $payment_method;
    }

    /**
     * @param $number
     * @param $exp_month
     * @param $exp_year
     * @param $cvc
     * @return \Stripe\PaymentMethod
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createPaymentMethod($number, $exp_month, $exp_year, $cvc)
    {
        return $this->stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => $number,
                'exp_month' => $exp_month,
                'exp_year' => $exp_year,
                'cvc' => $cvc,
            ],
        ]);
    }

    /**
     * @param $customerId
     * @param $subscriptionId
     * @param $coupon
     * @return \Stripe\Subscription
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createSubscription($customerId, $subscriptionId, $coupon = null)
    {
        $subscription = [
            'customer' => $customerId,
            'items' => [
                ['price' => $subscriptionId],
            ],
            'expand' => ['latest_invoice.payment_intent'],
        ];
        if ($tax = Tax::active()->stripe_id ?? null) {
            $subscription += ['default_tax_rates' => [$tax]];
        }
        if ($coupon) {
            $subscription += ['coupon' => $coupon];
        }
        return $this->stripe->subscriptions->create($subscription);
    }

    public function updateSubscription($ids, $data)
    {
        $ids = is_array($ids) ? $ids : [$ids];
        foreach ($ids as $id) {
            $this->stripe->subscriptions->update($id,$data);
        }
    }

    /**
     * @param $subscriptionId
     * @return \Stripe\Subscription
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getSubscription($subscriptionId)
    {
        return $this->stripe->subscriptions->retrieve(
            $subscriptionId,
            []
        );
    }

    /**
     * @param $subscriptionId
     * @return \Stripe\Subscription
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function cancelSubscription($subscriptionId)
    {
        return $this->stripe->subscriptions->cancel(
            $subscriptionId,
            []
        );
    }

    /**
     * @param float $amount
     * @param $interval
     * @param int $interval_count
     * @return \Stripe\Plan
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createPlan(float $amount, $interval, $interval_count = 1)
    {
        return $this->stripe->plans->create([
            'amount' => $amount * 100,
            'currency' => Setting::get('currency'),
            'interval' => $interval,
            'product' => Setting::get('stripe_product'),
            'interval_count' => $interval_count
        ]);
    }

    /**
     * @param $planId
     * @return \Stripe\Plan
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function deletePlan($planId)
    {
        return $this->stripe->plans->delete(
            $planId,
            []
        );
    }

    /**
     * @throws \Stripe\Exception\ApiErrorException
     */
    private function createProduct()
    {
        return $this->stripe->products->create([
            'name' => env('APP_NAME'),
        ]);
    }

    /**
     * @param $customerId
     * @return mixed
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getPaymentsMethods($customerId)
    {
        $methods = $this->stripe->customers->allPaymentMethods(
            $customerId,
            ['type' => 'card']
        );

        return $methods['data'];
    }

    /**
     * @param $methodId
     * @return \Stripe\PaymentMethod
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function deletePaymentMethod($methodId)
    {
        return $this->stripe->paymentMethods->detach(
            $methodId,
            []
        );
    }

    /**
     * @param $type
     * @param $discount
     * @param $end
     * @return \Stripe\Coupon
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createCoupon($type, $discount, $end)
    {
        if ($type == 'percent') {
            $coupon = ['percent_off' => $discount];
        } else {
            $coupon = [
                'amount_off' => $discount,
                'currency' => Setting::get('currency')
            ];
        }
        $coupon += [
            'duration' => 'forever',
            'redeem_by' => $end
        ];
        return $this->stripe->coupons->create($coupon);
    }

    /**
     * @param $id
     * @return \Stripe\Coupon
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function destroyCoupon($id)
    {
        return $this->stripe->coupons->delete($id, []);
    }

    /**
     * @param $name
     * @param $percent
     * @param $active
     * @param $inclusive
     * @return \Stripe\TaxRate
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createTax($name, $percent, $active, $inclusive)
    {
        return $this->stripe->taxRates->create([
            'display_name' => $name,
            'percentage' => $percent,
            'active' => $active,
            'inclusive' => $inclusive,
        ]);
    }

    /**
     * @param $id
     * @param $active
     * @param null $name
     * @return \Stripe\TaxRate
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function updateTax($id, $active, $name = null)
    {
        $tax = ['active' => $active];
        if ($name) {
            $tax += ['display_name' => $name];
        }
        return $this->stripe->taxRates->update($id, $tax);
    }
}
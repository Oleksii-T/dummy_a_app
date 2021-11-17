<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DestroyStripeRequest;
use App\Http\Requests\Api\StripeRequest;
use App\Models\Setting;
use App\Models\Promocode;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use App\Services\StripeService;

class StripeController extends Controller
{
    /**
     * @var StripeService
     */
    private $stripeService;

    /**
     * StripeController constructor.
     */
    public function __construct()
    {
        try {
            $this->stripeService = new StripeService();
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * @param StripeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StripeRequest $request)
    {
        try {
            $user = auth()->user();
            $subscriptionPlan = SubscriptionPlan::find($request->subscriptionPlanId);

            $this->stripeService->getPaymentMethod($request->paymentMethodId, $user->stripe_id);
            $this->stripeService->updateDefaultPaymentMethod($user, $request->paymentMethodId, $request->saveMethod);
            $coupon = $request->promocode
                ? Promocode::find($request->promocode)->stripe_coupon_id
                : null;
            $subscription = $this->stripeService->createSubscription($user->stripe_id, $subscriptionPlan->stripe_id, $coupon);

            $user->subscriptions()->create([
                'subscription_plan_id' => $subscriptionPlan->id,
                'expire_at' => Carbon::createFromTimestamp($subscription['current_period_end']),
                'stripe_id' => $subscription['id']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }
}

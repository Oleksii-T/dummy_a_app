<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Services\StripeService;
use App\Services\PaypalService;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * @var StripeService
     */
    private $stripeService;
    
    /**
     * @var PaypalService
     */
    private $paypalService;

    /**
     * StripeController constructor.
     */
    public function __construct()
    {
        try {
            $this->stripeService = new StripeService();
            $this->paypalService = new PaypalService();
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * @param Subscription $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Subscription $subscription)
    {
        try {
            abort_if($subscription->user_id != auth()->id(), 401);

            $subscription->update([
                'expire_at' => Carbon::now(),
                'is_active' => false
            ]);

            if ($subscription->stripe_id) {
                $this->stripeService->cancelSubscription($subscription->stripe_id);
            }
            if ($subscription->paypal_id) {
                $this->paypalService->cancelSubscription($subscription->paypal_id);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Subscription deleted successfully'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaypalRequest;
use App\Models\SubscriptionPlan;
use App\Services\PaypalService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaypalController extends Controller
{
    public function approve(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        try {
            $paypalService = new PaypalService();
            $subscription = $paypalService->getSubscription($request->subscription_id);
            if ($subscription['status'] != 'ACTIVE') {
                return redirect()->route('website.profile')->with('error', 'Payment is not valid');
            }
            $user = auth()->user();
            $user->subscriptions()->create([
                'subscription_plan_id' => $subscriptionPlan->id,
                'expire_at' => Carbon::parse($subscription['billing_info']['next_billing_time']),
                'paypal_id' => $subscription['id']
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('website.profile')->with('error', 'Payment is not valid');
        }
        return redirect()->route('website.profile')->with('success', 'Successfully subscribed to "'.$subscriptionPlan->title.'"');
    }
}
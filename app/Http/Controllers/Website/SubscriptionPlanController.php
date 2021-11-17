<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index(Request $request)
    {
        $plansByIntervals = [];
        $trial = SubscriptionPlan::where('free_plan', 1)->first();
        foreach (SubscriptionPlan::INTERVALS as $interval) {
            $plans = SubscriptionPlan::where('interval', $interval)->where('free_plan', 0)->orderBy('price')->get();
            if ($plans->isNotEmpty()) {
                if ($trial) {
                    $plans = $plans->prepend($trial);
                }
                $plansByIntervals[$interval] = $plans;
            }
        }
        return view('website.pricing', compact('plansByIntervals'));
    }

    public function subscribe(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $user = auth()->user();
        if (!$user) {
            session(['subscribe-after-auth' => $subscriptionPlan->id]);
            return redirect()->route('website.login');
        }
        if ($subscriptionPlan->free_plan) {
            if ($user->activePlans()->get()->pluck('subscription_plan_id')->contains($subscriptionPlan->id)) {
                return redirect()->route('website.subscription-plans.index')->with('error', 'You already subscriped for ' . $subscriptionPlan->title);
            }
            $user->subscriptions()->create([
                'subscription_plan_id' => $subscriptionPlan->id,
                'expire_at' => $subscriptionPlan->calculateExpiry()
            ]);
            return redirect()->route('website.profile')->with('success', 'Successfully subscribed to Trial period');
        }
        return redirect()->route('website.checkout.index', $subscriptionPlan->id);
    }
}

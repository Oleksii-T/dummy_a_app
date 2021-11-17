<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Http\Requests\Website\ProfileRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\StripeService;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $page = Page::get('account');

        if (session('subscribe-after-auth')) {
            $plan = SubscriptionPlan::find(session('subscribe-after-auth'));
            session()->forget('subscribe-after-auth');
            if (!$plan->free_plan) {
                return redirect()->route('website.checkout.index', $plan->id);
            }
            if ($user->activePlans()->get()->pluck('subscription_plan_id')->contains($plan->id)) {
                return redirect()->route('website.subscription-plans.index')->with('error', 'You already subscriped for ' . $plan->title);
            }
            $user->subscriptions()->create([
                'subscription_plan_id' => $plan->id,
                'expire_at' => $plan->calculateExpiry()
            ]);
            session()->flash('success', 'Successfully subscribed to Trial period');
        }

        try {
            $stripeService = new StripeService();
            $paymentMethods = $stripeService->getPaymentsMethods($user->stripe_id);
        } catch (\Exception $e) {
            $paymentMethods = [];
        }

        return view('website.profile', compact('page', 'paymentMethods'));
    }

    public function update(ProfileRequest $request)
    {
        try {
            $data = $request->validated();
            $user = auth()->user();
            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Profile update fails'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'profile updated successfully'
        ]);
    }

    public function destroyPaymentMethod(Request $request)
    {
        try {
            $stripeService = new StripeService();
            $method = $stripeService->deletePaymentMethod($request->method);
            $user = auth()->user();
            if ($user->stripe_default_payment_id == $method['id']) {
                $user->update([
                    'stripe_default_payment_id' => null
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Payment method deleted successfully'
        ]);
    }

    
    public function setDefaultPaymentMethod(Request $request)
    {
        try {
            auth()->user()->update([
                'stripe_default_payment_id' => $request->method
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Default payment method updated successfully'
        ]);
    }
}
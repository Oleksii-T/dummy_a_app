<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\StripeService;
use App\Models\SubscriptionPlan;
use App\Models\Setting;
use App\Models\Promocode;
use App\Models\Tax;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * @param SubscriptionPlan $subscriptionPlan
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     * @throws \Exception
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function index(SubscriptionPlan $subscriptionPlan)
    {
        if (!auth()->user()->stripe_id) {
            $stripeService = new StripeService();
            $stripeService->createCustomer(auth()->user());
        }
        $summary['currency'] = Setting::get('currency');
        $summary['currencySign'] = Setting::get('currency_sign');
        $summary['total'] = $subscriptionPlan->price_readable;
        if ($summary['vat'] = Tax::active()?->percentage) {
            $vatPrice = $subscriptionPlan->price * ($summary['vat']/100);
            $summary['total'] = $summary['currencySign'] . number_format($subscriptionPlan->price+$vatPrice, 2, '.');
        }

        $defaultPaymentMethod = auth()->user()->defaultPaymentMethod();

        return view('website.checkout.index', compact('subscriptionPlan', 'summary', 'defaultPaymentMethod'));
    }

    public function promocode($plan, $promocode)
    {
        try {
            $now = Carbon::now();
            $promocode = Promocode::where('code', $promocode)
                ->where('active_from', '<=', $now)
                ->where('active_to', '>=', $now)
                ->first();
            if (!$promocode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Promocode not found',
                ]);
            }
            $plan = SubscriptionPlan::findOrFail($plan);
            $currencySign = Setting::get('currency_sign');
            
            if ($promocode->type == 'percent') {
                $price = $plan->price - ($plan->price * ($promocode->discount/100));
                $disountReadable = "-$promocode->discount%";
            } else {
                $price = $plan->price - $promocode->discount;
                $disountReadable = "-$currencySign$promocode->discount";
            }

            if ($vat = Tax::active()?->percentage) {
                $price = $price + ($price * ($vat/100));
            }

            $priceReadable = $currencySign . number_format($price, 2, '.');
            
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }
        return response()->json([
            'success' => true,
            'id' => $promocode->id,
            'price' => $price,
            'priceReadable' => $priceReadable,
            'discount' => $promocode->discount,
            'type' => $promocode->type,
            'discountReadable' => $disountReadable
        ]);
    }
}

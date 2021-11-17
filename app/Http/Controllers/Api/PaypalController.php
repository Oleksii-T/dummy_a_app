<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaypalRequest;
use App\Models\Promocode;
use App\Models\SubscriptionPlan;
use App\Services\PaypalService;

class PaypalController extends Controller
{
    private $paypalService;

    /**
     * PaypalController constructor.
     */
    public function __construct()
    {
        try {
            $this->paypalService = new PaypalService();
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * @param PaypalRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PaypalRequest $request)
    {
        try {
            $subscriptionPlan = SubscriptionPlan::find($request->subscriptionPlanId);
            $coupon = $request->promocode ? Promocode::find($request->promocode) : null;
            $res = $this->paypalService->createSubscription($subscriptionPlan, $coupon);

            $res['links'] = array_filter($res['links'], function ($item) {
                return isset($item['rel']) && $item['rel'] == 'approve';
            });

            $approveLink = $res['links'][0]['href'] ?? null;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'link' => $approveLink ?? null
        ]);
    }
}

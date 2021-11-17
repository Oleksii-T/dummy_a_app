<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubscriptionPlanRequest;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use App\Services\StripeService;
use App\Services\PaypalService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubscriptionPlanController extends Controller
{
    /**
     * @var StripeService
     */
    private $stripeService;
    
    private $paypalService;
    
    /**
     * SubscriptionPlanController constructor.
     */
    public function __construct()
    {
        try {
            $this->stripeService = new StripeService();
            $this->paypalService = new PaypalService();
        } catch (\Exception $e) {
            redirect()->route('admin.settings.payment')->with('error', $e->getMessage())->send();
        }
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.subscription-plans.index');
        }

        return $this->makeDatatable(SubscriptionPlan::query());
    }

    /**
     * @param $subscriptionPlans
     * @return mixed
     * @throws \Exception
     */
    private function makeDatatable($subscriptionPlans)
    {
        return DataTables::of($subscriptionPlans)
            ->editColumn('price', function ($subscriptionPlan) {
                return $subscriptionPlan->price > 0 ?
                    $subscriptionPlan->price . ' ' . strtoupper(Setting::get('currency')) : 'Free';
            })
            ->editColumn('interval', function ($subscriptionPlan) {
                return ucfirst($subscriptionPlan->interval);
            })
            ->addColumn('action', function ($subscriptionPlan) {
                return view('admin.subscription-plans.components.action-list', compact('subscriptionPlan'))
                    ->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function create()
    {
        return view('admin.subscription-plans.create');
    }

    /**
     * @param SubscriptionPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SubscriptionPlanRequest $request)
    {
        try {
            $subscriptionPlan = SubscriptionPlan::create($request->validated());

            if ($subscriptionPlan->checkStripeInterval() && $request->price) {
                $stripePlan = $this->stripeService->createPlan(
                    $subscriptionPlan->price, 
                    $subscriptionPlan->interval,
                    $subscriptionPlan->number_intervals
                );
                $subscriptionPlan->update([
                    'stripe_id' => $stripePlan['id']
                ]);
            }
            if ($subscriptionPlan->checkPaypalInterval() && $request->price) {
                $paypalPlan = $this->paypalService->createPlan(
                    $subscriptionPlan->price, 
                    $subscriptionPlan->interval, 
                    $subscriptionPlan->number_intervals, 
                    $subscriptionPlan->title, 
                    $subscriptionPlan->description
                );
                $subscriptionPlan->update([
                    'paypal_id' => $paypalPlan['id']
                ]);
            }
        } catch (\Throwable $th) {
            if (isset($subscriptionPlan)) {
                $subscriptionPlan->delete();
            }

            return response()->json([
                'success' => false,
                'log' => $th->getMessage(),
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Subscription plan created successfully',
            'redirect' => route('admin.subscription-plans.index')
        ]);
    }

    /**
     * @param SubscriptionPlan $subscriptionPlan
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscription-plans.edit', compact('subscriptionPlan'));
    }

    /**
     * @param SubscriptionPlanRequest $request
     * @param SubscriptionPlan $subscriptionPlan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SubscriptionPlanRequest $request, SubscriptionPlan $subscriptionPlan)
    {
        try {
            $subscriptionPlan->update($request->validated());
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Subscription plan updated successfully',
            'redirect' => route('admin.subscription-plans.index')
        ]);
    }

    /**
     * @param SubscriptionPlan $subscriptionPlan
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        try {
            $this->stripeService->deletePlan($subscriptionPlan->stripe_id);
            $this->paypalService->deletePlan($subscriptionPlan->paypal_id);

            $subscriptionPlan->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "The Subscription plan #$subscriptionPlan->id successfully deleted!"
        ]);
    }
}

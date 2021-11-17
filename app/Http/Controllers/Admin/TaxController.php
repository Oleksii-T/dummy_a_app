<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tax;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Http\Requests\Admin\TaxRequest;
use Yajra\DataTables\DataTables;
use App\Services\StripeService;
use App\Services\PaypalService;

class TaxController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()){
            return view('admin.taxes.index');
        }


        return $this->makeDatatable(Tax::query());
    }

    private function makeDatatable($taxes)
    {
        return DataTables::of($taxes)
            ->editColumn('is_active', function ($tax) {
                return $tax->is_active 
                    ? '<span class="badge badge-success">active</span>' 
                    : '<span class="badge badge-danger">inactive</span>';
            })
            ->editColumn('is_inclusive', function ($tax) {
                return $tax->is_inclusive
                    ? '<span class="badge badge-info">inclusive</span>' 
                    : '<span class="badge badge-info">exclusive</span>';
            })
			->addColumn('action', function($tax){
				return view('admin.taxes.components.action-list', compact('tax'))->render();
			})
            ->rawColumns(['is_active', 'is_inclusive', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.taxes.create');
    }

    public function store(TaxRequest $request)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = isset($data['is_active']) ? true : false;
            $data['is_inclusive'] = isset($data['is_inclusive']) ? true : false;
            $stripeService = new StripeService();
            $sTax = $stripeService->createTax($data['title'], $data['percentage'], $data['is_active'], $data['is_inclusive']);
            $data += [
                'stripe_id' => $sTax['id']
            ];
            if ($data['is_active']) {
                $stripeSubscriptions = Subscription::whereNotNull('stripe_id')->where('is_active', true)->pluck('stripe_id')->toArray();
                $subData = [
                    'default_tax_rates' => [$sTax['id']]
                ];
                $stripeService->updateSubscription($stripeSubscriptions, $subData);

                $paypalPlans = SubscriptionPlan::whereNotNull('paypal_id')->pluck('paypal_id')->toArray();
                $planData = ['/taxes/percentage' => $data['is_inclusive'] ? 0 : $data['percentage']];
                (new PaypalService())->updatePlan($paypalPlans, $planData);

                $activeTaxes = Tax::where('is_active', true)->get();
                foreach ($activeTaxes as $activeTax) {
                    $stripeService->updateTax($activeTax['stripe_id'], false);
                    $activeTax->update([
                        'is_active' => false
                    ]);
                }
            }
            $tax = Tax::create($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'debug' => $th->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tax created successfully',
            'redirect' => route('admin.taxes.index')
        ]);
    }

    public function edit(Tax $tax)
    {
        return view('admin.taxes.edit', compact('tax'));
    }

    public function update(TaxRequest $request, Tax $tax)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = isset($data['is_active']) ? true : false;
            $stripeService = new StripeService();
            
            $stripeService->updateTax($tax->stripe_id, $data['is_active'], $data['title']);

            if ($tax->is_active && !$data['is_active']) {
                $paypalTax = 0;
            } else if (!$tax->is_active && $data['is_active']) {
                $paypalTax = $tax->is_inclusive ? 0 : $tax->percentage;
                $stripeSubscriptions = Subscription::whereNotNull('stripe_id')->where('is_active', true)->pluck('stripe_id')->toArray();
                $subData = [
                    'default_tax_rates' => [$tax->stripe_id]
                ];
                $stripeService->updateSubscription($stripeSubscriptions, $subData);
            }
            if(isset($paypalTax)) {
                $paypalPlans = SubscriptionPlan::whereNotNull('paypal_id')->pluck('paypal_id')->toArray();
                $planData = ['/taxes/percentage' => $paypalTax];
                (new PaypalService())->updatePlan($paypalPlans, $planData);
            }

            if ($data['is_active']) {
                $activeTaxes = Tax::where('is_active', true)->where('id', '!=', $tax->id)->get();
                foreach ($activeTaxes as $activeTax) {
                    $stripeService->updateTax($tax['stripe_id'], false);
                    $activeTax->update([
                        'is_active' => false
                    ]);
                }
            }
            $tax->update($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'debug' => $th->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tax updated successfully',
            'redirect' => route('admin.taxes.index')
        ]);
    }

    public function destroy(Tax $tax)
    {
        (new StripeService())->updateTax($tax->stripe_id, false);
        $tax->delete();

		return response()->json([
            'success' => true,
			'message' => "The tax #$tax->id successfully deleted!"
        ]);
    }
}
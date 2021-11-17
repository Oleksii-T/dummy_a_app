<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Services\StripeService;
use App\Services\PaypalService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.subscriptions.index');
        }

        return $this->makeDatatable(Subscription::query());
    }

    private function makeDatatable($subscriptions)
    {
        return DataTables::of($subscriptions)
            ->addColumn('user', function ($subscription) {
                $user = $subscription->user;
                return '<a href="'.route('admin.users.edit', $user).'">'.$user->full_name.'</a>';
            })
            ->addColumn('plan', function ($subscription) {
                $plan = $subscription->plan;
                return '<a href="'.route('admin.subscription-plans.edit', $plan).'">'.$plan->title.'</a>';
            })
            ->editColumn('created_at', function ($subscription) {
                return $subscription->created_at->format('Y-m-d H:i');
            })
            ->editColumn('expire_at', function ($subscription) {
                return $subscription->expire_at->format('Y-m-d H:i');
            })
            ->addColumn('action', function ($subscription) {
                return view('admin.subscriptions.components.action-list', compact('subscription'))->render();
            })
            ->rawColumns(['user', 'plan', 'action'])
            ->make(true);
    }

    public function show(Subscription $subscription)
    {
        return view('admin.subscriptions.show', compact('subscription'));
    }

    public function destroy(Subscription $subscription)
    {
        try {
            if ($subscription->stripe_id) {
                (new StripeService())->cancelSubscription($subscription->stripe_id);
            }
            if ($subscription->paypal_id) {
                (new PaypalService())->cancelSubscription($subscription->paypal_id);
            }
            $subscription->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "The Subscription #$subscription->id successfully deleted!"
        ]);
    }
}

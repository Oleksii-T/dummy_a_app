<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promocode;
use App\Http\Requests\Admin\PromocodeRequest;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Services\StripeService;

class PromocodeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()){
            return view('admin.promocodes.index');
        }

        return $this->makeDatatable(Promocode::query());
    }

    private function makeDatatable($promocodes)
    {
        $now = Carbon::now();
        if (request()->status !== null) {
            if (request()->status) {
                $promocodes->where('active_from', '<=', $now)->where('active_to', '>=', $now);
            } else {
                $promocodes->where(function($q) use($now){
                    $q->where('active_from', '>', $now)
                        ->orWhere('active_to', '<', $now);
                });
            }
        }
        if (request()->type) {
            $promocodes->where('type', request()->type);
        }

        return DataTables::of($promocodes)
            ->editColumn('type', function ($promocode) {
            })
            ->addColumn('status', function ($promocode) {
                return $promocode->is_active 
                    ? '<span class="badge badge-success">active</span>' 
                    : '<span class="badge badge-danger">inactive</span>';
            })
            ->editColumn('type', function($promocode){
                return $promocode->type;
            })
			->addColumn('action', function($promocode){
				return view('admin.promocodes.components.action-list', compact('promocode'))->render();
			})
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.promocodes.create');
    }

    public function store(PromocodeRequest $request)
    {
        try {
            $data = $request->validated();
            $data['active_from_to'] = explode(' - ', $data['active_from_to']);
            $data['active_from'] = $data['active_from_to'][0];
            $data['active_to'] = $data['active_from_to'][1];
            $stripeService = new StripeService();
            $sCoupon = $stripeService->createCoupon($data['type'], $data['discount'], Carbon::parse($data['active_to'])->timestamp);
            $data += [
                'stripe_coupon_id' => $sCoupon['id']
            ];
            $promocode = Promocode::create($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Promocode created successfully',
            'redirect' => route('admin.promocodes.index')
        ]);
    }

    public function edit(Promocode $promocode)
    {
        return view('admin.promocodes.edit', compact('promocode'));
    }

    public function update(PromocodeRequest $request, Promocode $promocode)
    {
        try {
            $data = $request->validated();
            $promocode->update($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Promocode updated successfully',
            'redirect' => route('admin.promocodes.index')
        ]);
    }

    public function destroy(Promocode $promocode)
    {
        (new StripeService())->destroyCoupon($promocode->stripe_coupon_id);
        $promocode->delete();

		return response()->json([
            'success' => true,
			'message' => "The promocode #$promocode->id successfully deleted!"
        ]);
    }
}
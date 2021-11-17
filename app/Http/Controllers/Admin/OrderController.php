<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Requests\Admin\OrderRequest;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function index(Request $request){
        if (!$request->ajax()){
            return view('admin.orders.index');
        }

        return $this->makeDatatable(Order::query());
    }

    private function makeDatatable($orders)
    {
        return DataTables::of($orders)
            ->editColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d H:i');
            })
            ->addColumn('user', function($order){
                if ($user = $order->user) {
                    return  '<a href="'.route('admin.users.edit', $user).'">'.$user->full_name.'</a>';
                }
                return null;
            })
			->addColumn('action', function($order){
				return view('admin.orders.components.action-list', compact('order'))->render();
			})
            ->rawColumns(['user', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(OrderRequest $request)
    {
        try {
            $data = $request->validated();
            Order::create($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => "Server error",
                'debug' => $th->getMessage()
            ]);
        }
		return response()->json([
            'success' => true,
			'message' => "The order successfully created!",
            'redirect' => route('admin.orders.index')
        ]);
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(OrderRequest $request, Order $order)
    {
        try {
            $data = $request->validated();
            $order->update($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => "Server error"
            ]);
        }
		return response()->json([
            'success' => true,
			'message' => "The order successfully update!",
            'redirect' => route('admin.orders.index')
        ]);
    }

    public function destroy(Order $order)
    {
		$order->delete();

		return response()->json([
            'success' => true,
			'message' => "The order #$order->id successfully deleted!"
        ]);
    }
}

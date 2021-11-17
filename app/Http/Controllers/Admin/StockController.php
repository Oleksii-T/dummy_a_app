<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StockTypeRequest;
use App\Models\Stock;
use App\Models\StockType;
use Yajra\DataTables\DataTables;
use App\Services\YahooFinanceParser;

class StockController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()){
            return view('admin.stocks.index');
        }

        return $this->makeDatatable(Stock::query());
    }

    private function makeDatatable($stocks)
    {
        if (request()->type !== null) {
            $stocks->where('stock_type_id', request()->type);
        }

        return DataTables::of($stocks)
            ->editColumn('date', function($stock){
                return $stock->date->format('Y-m-d');
            })
            ->editColumn('open', function($stock){
                return round($stock->open, 2);
            })
            ->editColumn('high', function($stock){
                return round($stock->high, 2);
            })
            ->editColumn('low', function($stock){
                return round($stock->low, 2);
            })
            ->editColumn('close', function($stock){
                return round($stock->close, 2);
            })
            ->editColumn('adj_close', function($stock){
                return round($stock->adj_close, 2);
            })
            ->make(true);
    }

    public function storeType(StockTypeRequest $request)
    {
        try {
            $data = $request->validated();
            $type = StockType::create($data);
            $stocks = YahooFinanceParser::getTable($type->name);
            $stocks = array_slice($stocks, 0, 30);
            foreach ($stocks as $stock) {
                $stock += [
                    'stock_type_id' => $type->id
                ];
                Stock::create($stock);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Stock type created successfully',
            'redirect' => route('admin.stocks.index')
        ]);
    }
}
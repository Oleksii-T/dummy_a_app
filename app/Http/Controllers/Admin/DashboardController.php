<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\Setting;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $visitorsGraph = $this->getVisitorsGraphData();
        $salesGraph = $this->getSalesGraphData();
        $orders = Order::latest()->limit(4)->get();
        $subscriptions = Subscription::latest()->limit(4)->get();
        return view('admin.dashboard', compact('visitorsGraph', 'salesGraph', 'orders', 'subscriptions'));
    }

    private function getVisitorsGraphData()
    {
        $visitorsByDate = Visitor::whereDate('created_at', '>', \Carbon\Carbon::now()->subDays(7));
        
        $graph['last'] = $this->getVisitorsGraphDataHelper($visitorsByDate);
        
        $visitorsByDate = Visitor::whereDate('created_at', '<=', \Carbon\Carbon::now()->subDays(7))
            ->whereDate('created_at', '>', \Carbon\Carbon::now()->subDays(14));
        
        $graph['pre-last'] = $this->getVisitorsGraphDataHelper($visitorsByDate);

        $graph['diff']['is_raised'] = $graph['last']['total'] == $graph['pre-last']['total'] ? null : ($graph['last']['total'] > $graph['pre-last']['total'] ? true : false);
        $graph['diff']['amount'] = $graph['pre-last']['total']
            ? number_format(($graph['last']['total'] - $graph['pre-last']['total']) / $graph['pre-last']['total'] * 100, 2, '.', '')
            : 100;

        return $graph;
    }
    
    private function getSalesGraphData()
    {
        //TODO
        $salesByDate = Order::whereDate('created_at', '>', \Carbon\Carbon::now()->subYear());
        
        $graph['last'] = $this->getSalesGraphDataHelper($salesByDate);
        
        $salesByDate = Order::whereDate('created_at', '<=', \Carbon\Carbon::now()->subYear())
            ->whereDate('created_at', '>', \Carbon\Carbon::now()->subYears(2));
        
        $graph['pre-last'] = $this->getSalesGraphDataHelper($salesByDate);

        $graph['diff']['is_raised'] = $graph['last']['total'] == $graph['pre-last']['total'] ? null : ($graph['last']['total'] > $graph['pre-last']['total'] ? true : false);
        $graph['diff']['amount'] = $graph['pre-last']['total']
            ? number_format(($graph['last']['total'] - $graph['pre-last']['total']) / $graph['pre-last']['total'] * 100, 2, '.', '')
            : 100;

        $graph['last']['total'] = Setting::get('currency_sign') . number_format($graph['last']['total'], 2, '.');

        return $graph;
    }

    private function getSalesGraphDataHelper($salesByDate)
    {
        $salesByDate = $salesByDate->get()
            ->groupBy(function ($p) {
                return $p->created_at->format('Y.m');
            })->sortBy(function ($sale, $key) {
                return $key;
            });
        $graph['total'] = 0;
        foreach ($salesByDate as $date => $sales) {
            $graph['labels'][] = Carbon::createFromFormat('Y.m', $date)->format('M');
            $graph['values'][] = $sales->count();
            $graph['total'] += $sales->count();
        }

        return $graph;
    }

    private function getVisitorsGraphDataHelper($visitorsByDate)
    {
        $visitorsByDate = $visitorsByDate->get()
            ->groupBy(function ($p) {
                return $p->created_at->format('Y.m.d');
            })->sortBy(function ($visitor, $key) {
                return $key;
            });
        $graph['total'] = 0;
        foreach ($visitorsByDate as $date => $visitors) {
            $graph['labels'][] = Carbon::createFromFormat('Y.m.d', $date)->format('D');
            $graph['values'][] = $visitors->count();
            $graph['total'] += $visitors->count();
        }

        return $graph;
    }
}

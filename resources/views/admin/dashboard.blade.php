@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <span id="visitors-graph" hidden>{{json_encode($visitorsGraph)}}</span>
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Visitors</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg">{{$visitorsGraph['last']['total']}}</span>
                                        <span>Visitors Over Time</span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right">
                                    <span class="{{ is_null($visitorsGraph['diff']['is_raised']) ? null : ($visitorsGraph['diff']['is_raised'] ? 'text-success' : 'text-danger') }}">
                                        @if(!is_null($visitorsGraph['diff']['is_raised']))
                                            <i class="fas {{ $visitorsGraph['diff']['is_raised'] ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                        @endif
                                        {{$visitorsGraph['diff']['amount']}}%
                                    </span>
                                        <span class="text-muted">Since last week</span>
                                    </p>
                                </div>

                                <div class="position-relative mb-4">
                                    <canvas id="visitors-chart" height="200"></canvas>
                                </div>

                                <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This Week
                                </span>

                                <span>
                                    <i class="fas fa-square text-gray"></i> Last Week
                                </span>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header border-0">
                                <h3 class="card-title">Resent orders</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-striped table-valign-middle">
                                    <thead>
                                    <tr>
                                        <th>Order id</th>
                                        <th>Users</th>
                                        <th>Price</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{$order->number}}</td>
                                                <td>
                                                    @if ($order->user->image)
                                                        <img src="{{$order->user->image->url}}" alt="User avatar" class="img-circle img-size-32 mr-2">
                                                    @endif
                                                    {{$order->user->full_name}}
                                                </td>
                                                <td>${{$order->amount}} USD</td>
                                                <td>
                                                    {{$order->created_at->format('Y-m-d H:i')}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <span id="sales-graph" hidden>{{json_encode($salesGraph)}}</span>
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Revenue</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg">$18,230.00</span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> 33.1%
                                    </span>
                                        <span class="text-muted">Since last month</span>
                                    </p>
                                </div>

                                <div class="position-relative mb-4">
                                    <canvas id="sales-chart" height="200"></canvas>
                                </div>

                                <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This year
                                </span>

                                    <span>
                                    <i class="fas fa-square text-gray"></i> Last year
                                </span>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header border-0">
                                <h3 class="card-title">Resent subscriptions</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-striped table-valign-middle">
                                    <thead>
                                    <tr>
                                        <th>Subscription id</th>
                                        <th>Users</th>
                                        <th>Pricing Plan</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscriptions as $subscription)
                                            <tr>
                                                <td>{{$subscription->id}}</td>
                                                <td>
                                                    @if ($subscription->user->image)
                                                        <img src="{{$subscription->user->image->url}}" alt="User avatar" class="img-circle img-size-32 mr-2">
                                                    @endif
                                                    {{$subscription->user->full_name}}
                                                </td>
                                                <td>{{$subscription->plan->title}}</td>
                                                <td>
                                                    {{$subscription->created_at->format('Y-m-d')}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/admin/js/dashboard.js')}}"></script>
@endpush

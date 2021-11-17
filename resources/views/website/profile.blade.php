@extends('website.layouts.app')
@php($body_class = 'account-page')

@section('header')
    @include('website.layouts.inc.header')
@endsection

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="account first-section-padding">
                <div class="container">
                    <div class="heading-account">
                        <h3>Account</h3>
                        <span>Change your profile and account setting</span>
                        @if (session('success'))
                            <br>
                            <span class="custom-success">{{session('success')}}</span>
                        @endif
                        @if (session('error'))
                            <br>
                            <span class="custom-error">{{session('error')}}</span>
                        @endif
                    </div>
                    <div class="content-account">
                        <div class="account-sidebar1 tabs">
                            <div class="mobile-select-menu">
                            <span>
                                <img src="{{asset('assets/website/img/orders-icon.svg')}}" alt="">
                                Orders
                            </span>
                                <img src="{{asset('assets/website/img/arrow-mobile-select.svg')}}">
                            </div>
                            <ul class="hidden-list">
                                <li class="current" rel="orders">
                                    <a href="#">
                                        {{--<img src="{{asset('assets/website/img/orders-icon.svg')}}" alt="">--}}
                                        <?php include 'assets/website/img/orders-icon.svg'?>
                                        Orders
                                    </a>
                                </li>
                                <li rel="subscriptions">
                                    <a href="#">
                                        <?php include 'assets/website/img/subscriptions-icon.svg'?>
                                        Subscriptions
                                    </a>
                                </li>
                                <li rel="payment-methods">
                                    <a href="#">
                                        <?php include 'assets/website/img/payments-methods-icon.svg'?>
                                        Payment Methods
                                    </a>
                                </li>
                                <li rel="account-detail">
                                    <a href="#">
                                        <?php include 'assets/website/img/account-details-icon.svg'?>
                                        Account Details
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="document.getElementById('logout-form').submit()">
                                        <?php include 'assets/website/img/logaut-icon.svg'?>
                                        Logout
                                    </a>
                                    <form action="{{route('logout')}}" method="post" class="hidden" id="logout-form">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <div class="account-content">
                            <!-- #1 Orders -->
                            <div id="orders" class="current tab-content">
                                <div class="heading-tab">
                                    <h3>Orders</h3>
                                </div>
                                <div class="tab-info">
                                    @if ($currentUser->orders->isEmpty())
                                        <p>You have no orders yet</p>
                                    @else
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($currentUser->orders as $order)
                                                    <tr>
                                                        <th class="order">#{{$order->number}}</th>
                                                        <th class="date">{{$order->created_at->format('Y-m-d H:i')}}</th>
                                                        <th class="description">{{$order->description}}</th>
                                                        <th class="status">{{$order->status}}</th>
                                                        <th class="total">${{$order->amount}}</th>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>

                            <!-- #2 Subscriptions -->
                            <div id="subscriptions" class="tab-content">
                                <div class="heading-tab">
                                    <h3>Subscriptions</h3>
                                </div>
                                <div class="tab-info">
                                    @if ($currentUser->subscriptions()->count())
                                        @foreach ($currentUser->subscriptions()->latest()->get() as $subscription)
                                            <div class="list-subscription {{$subscription->isActive() ? 'active' : ''}}">
                                                @if ($subscription->isActive())
                                                    <span class="active-subscription-label">Active</span>
                                                @endif
                                                <div class="subscription-item">
                                                    <span>Your Subscription:</span>
                                                    <span>{{$subscription->plan->title}} ({{$subscription->plan->number_intervals . ' ' . $subscription->plan->interval}})</span>
                                                </div>
                                                <div class="subscription-item">
                                                    <span>Start Date:</span>
                                                    <span>{{$subscription->created_at->format('F d, Y')}}</span>
                                                </div>
                                                <div class="subscription-item">
                                                    <span>Finish Date:</span>
                                                    <span>{{$subscription->expire_at->format('F d, Y')}}</span>
                                                </div>
                                                @if ($subscription->isActive())
                                                    <div class="subscription-item">
                                                        <div class="actions">
                                                            <a href="#" class="btn btn-white btn-sm cancel-subscription" data-subscription="{{$subscription->id}}">Cancel Subscription</a>
                                                            {{-- <a href="#" class="btn btn-blue btn-sm">Upgrade Account</a> --}}
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        No subscription found
                                    @endif
                                </div>
                            </div>

                            <!-- #3 Payment Methods -->
                            <div id="payment-methods" class="tab-content">
                                <div class="payment-methods-block1">
                                    <div class="heading-tab">
                                        <h3>Payment Methods</h3>
                                        {{-- <a href="#" class="btn btn-sm btn-white open-add-payments">+ Add Payment Method</a> --}}
                                    </div>
                                    <div class="tab-info">
                                        @if ($paymentMethods)
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>Methods</th>
                                                    <th>Expires</th>
                                                    {{-- <th>Subscriptions</th> --}}
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($paymentMethods as $method)
                                                        <tr>
                                                            <th class="methods">
                                                                <div class="card">
                                                                    @if (cardImage($method['card']['brand']))
                                                                        <img src="{{cardImage($method['card']['brand'])}}">  
                                                                    @endif
                                                                    <span class="hidden-text">•••• •••• ••••</span>
                                                                    <span class="visible-text">&nbsp;{{$method['card']['last4']}}</span>
                                                                </div>
                                                            </th>
                                                            <th class="expires">{{$method['card']['exp_month'] . '/' . $method['card']['exp_year']}}</th>
                                                            <th class="actions">
                                                                <div class="action-links">
                                                                    <a href="#" data-method="{{$method['id']}}" class="btn btn-xs btn-white set-default-method {{$currentUser->stripe_default_payment_id==$method['id'] ? 'disable' : ''}}">Default Card</a>
                                                                    <a href="#" data-method="{{$method['id']}}" class="btn btn-xs btn-white delete-method">Delete</a>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            No saved method found
                                        @endif
                                    </div>
                                </div>
                                <form class="payment-methods-block2 hidden-payment">
                                    <div class="heading-tab">
                                        <h3>+ Add Payment Method</h3>
                                    </div>
                                    <div class="tab-info tabs-pd">
                                        <div class="account-sidebar2 tabs">
                                            <ul class="custom-tabs">
                                                <li class="current" rel="credit-card">
                                                    <a href="#">
                                                        Credit Card
                                                    </a>
                                                </li>
                                                <li rel="paypal">
                                                    <a href="#">
                                                        PayPal
                                                    </a>
                                                </li>
                                                <li rel="annual">
                                                    <a href="#">
                                                        Annual
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="account-content">
                                            <div id="credit-card" class="tab-content2 current">
                                                <h3>Add credit card</h3>

                                                <div class="input-group">
                                                    <label class="input-group__title">Card Number</label>
                                                    <input type="text" class="input" placeholder="•••• •••• •••• 1234">
                                                </div>
                                                <div class="input-group-row">
                                                    <div class="input-group-col-2">
                                                        <div class="input-group">
                                                            <label class="input-group__title">
                                                                Expiration Date
                                                            </label>
                                                            <input type="text" class="input" placeholder="12 / 24">
                                                        </div>
                                                    </div>
                                                    <div class="input-group-col-2">
                                                        <div class="input-group">
                                                            <label class="input-group__title">
                                                                CCV Code
                                                            </label>
                                                            <input type="password" class="input" placeholder="•••">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div id="paypal" class="tab-content2">
                                                <h3>Add PayPal card</h3>

                                                <div class="input-group">
                                                    <label class="input-group__title">Card Number</label>
                                                    <input type="text" class="input" placeholder="•••• •••• •••• 1234">
                                                </div>
                                                <div class="input-group-row">
                                                    <div class="input-group-col-2">
                                                        <div class="input-group">
                                                            <label class="input-group__title">
                                                                Expiration Date
                                                            </label>
                                                            <input type="text" class="input" placeholder="12 / 24">
                                                        </div>
                                                    </div>
                                                    <div class="input-group-col-2">
                                                        <div class="input-group">
                                                            <label class="input-group__title">
                                                                CCV Code
                                                            </label>
                                                            <input type="password" class="input" placeholder="•••">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="annual" class="tab-content2">
                                                <h3>Add crypto wallet</h3>

                                                <div class="input-group">
                                                    <label class="input-group__title">Crypto Wallet</label>
                                                    <input type="text" class="input" placeholder="•••• •••• •••• 1234">
                                                </div>
                                                <div class="input-group">
                                                    <label class="input-group__title">Email address</label>
                                                    <input type="text" class="input" placeholder="alma.lawson@example.com">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="actions-butts">
                                        <a href="#" class="btn btn-white btn-form btn-exit">Cancel</a>
                                        <button type="submit" class="btn btn-blue btn-form">Save Card</button>
                                    </div>
                                </form>
                            </div>

                            <!-- #4 Account Details -->
                            <div id="account-detail" class="tab-content">
                                <form action="{{route('website.profile.update')}}" id="profile-update" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="heading-tab">
                                        <h3>Account Details</h3>
                                    </div>
                                    <div class="account-content">
                                        <div class="tab-info">
                                            <div class="padding">
                                                <h3>Personal Information</h3>

                                                <div class="form-content">
                                                    <div class="input-group-row">
                                                        <div class="input-group-col-2">
                                                            <div class="input-group">
                                                                <label class="input-group__title">
                                                                    First Name
                                                                </label>
                                                                <input type="text" class="input" name="first_name" value="{{$currentUser->first_name}}">
                                                                <span data-field="first_name" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                        <div class="input-group-col-2">
                                                            <div class="input-group">
                                                                <label class="input-group__title">
                                                                    Last Name
                                                                </label>
                                                                <input type="text" class="input" name="last_name" value="{{$currentUser->last_name}}">
                                                                <span data-field="last_name" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="input-group-row">
                                                        <div class="input-group-col-2">
                                                            <div class="input-group">
                                                                <label class="input-group__title">
                                                                    Display Name
                                                                </label>
                                                                <input type="text" class="input" name="username" value="{{$currentUser->username}}">
                                                                <span data-field="username" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                        <div class="input-group-col-2">
                                                            <div class="input-group">
                                                                <label class="input-group__title">
                                                                    Email Address
                                                                </label>
                                                                <input type="text" class="input" name="email" value="{{$currentUser->email}}">
                                                                <span data-field="email" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <h3>Password Change</h3>

                                                <div class="form-content">
                                                    <div class="input-group-row">
                                                        <div class="input-group-col-2">
                                                            <div class="input-group">
                                                                <label class="input-group__title">
                                                                    New Password
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <input type="password" name="password" class="input" placeholder="•••••••••••••••••••••">
                                                                    <button type="button" class="input-button">
                                                                        <img src="{{asset('assets/website/img/eye-cross_1.svg')}}">
                                                                    </button>
                                                                </div>
                                                                <span data-field="password" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                        <div class="input-group-col-2">
                                                            <div class="input-group">
                                                                <label class="input-group__title">
                                                                    Confirm New Password
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <input type="password" name="password_confirmation" class="input" placeholder="•••••••••••••••••••••">
                                                                    <button type="button" class="input-button">
                                                                        <img src="{{asset('assets/website/img/eye-cross_1.svg')}}">
                                                                    </button>
                                                                </div>
                                                                <span data-field="password_confirmation" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="actions-butts">
                                        <button type="submit" class="btn btn-sm btn-blue">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection

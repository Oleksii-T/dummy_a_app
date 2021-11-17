@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Payment methods</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payment methods</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <form action="{{route('admin.settings.payment.update')}}" method="post" class="container-fluid general-ajax-submit">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card {{session('error') ? 'card-danger' : ''}}">
                            @if (session('error'))
                                <div class="card-header">
                                    <h3 class="card-title">{{session('error')}}</h3>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Stripe Secret Key</label>
                                            <input type="text" class="form-control" name="stripe_secret_key" value="{{\App\Models\Setting::get('stripe_secret_key')}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Stripe publishable key</label>
                                            <input type="text" class="form-control" name="stripe_publishable_key" value="{{\App\Models\Setting::get('stripe_publishable_key')}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Stripe product</label>
                                            <input type="text" class="form-control" name="stripe_product" value="{{\App\Models\Setting::get('stripe_product')}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Paypal client id</label>
                                            <input type="text" class="form-control" name="paypal_client_id" value="{{\App\Models\Setting::get('paypal_client_id')}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Paypal client secret</label>
                                            <input type="text" class="form-control" name="paypal_client_secret" value="{{\App\Models\Setting::get('paypal_client_secret')}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('admin.index')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

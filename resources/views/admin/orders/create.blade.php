@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Order</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.orders.index')}}">Orders</a></li>
                            <li class="breadcrumb-item active">Create Order</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <form action="{{route('admin.orders.store')}}" method="post" class="container-fluid general-ajax-submit">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Number</label>
                                            <input type="text" class="form-control" name="number">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="text" class="form-control" name="amount">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="description">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status" style="width: 100%;">
                                                @foreach (\App\Models\Order::STATUSES as $status)
                                                    <option value="{{$status}}">{{$status}}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>User</label>
                                            <select class="select2" name="user_id" style="width: 100%;">
                                                @foreach (\App\Models\User::all() as $user)
                                                    <option value="{{$user->id}}">{{$user->full_name}}</option>
                                                @endforeach
                                            </select>
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
                        <a href="{{route('admin.orders.index')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">Store</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

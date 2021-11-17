@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create subscription plan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.subscription-plans.index')}}">Subscription plans</a></li>
                            <li class="breadcrumb-item active">Create subscription plan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <form action="{{ route('admin.subscription-plans.store') }}" method="POST" class="general-ajax-submit">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" class="form-control">
                                                <span class="input-error text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Price ({{ \App\Models\Setting::get('currency') }})</label>
                                                <input type="number" name="price" min="0" step="0.01" class="form-control">
                                                <span class="input-error text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Interval</label>
                                                <select name="interval" class="select2" style="width:100%;">
                                                    @foreach(\App\Models\SubscriptionPlan::INTERVALS as $interval)
                                                        <option value="{{ $interval }}">{{ ucfirst($interval) }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="input-error text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Number of intervals</label>
                                                <input type="number" name="number_intervals" min="0" step="1" class="form-control">
                                                <span class="input-error text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-sm-12">
                                                <div class="form-check">
                                                    <input type="hidden" name="free_plan" value="0">
                                                    <input type="checkbox" value="1" name="free_plan" class="form-check-input" id="free_plan">
                                                    <label class="form-check-label" for="free_plan">Trial plan</label>
                                                    <span class="input-error text-danger" data-input="free_plan"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-check">
                                                    <input type="hidden" name="popular" value="0">
                                                    <input type="checkbox" value="1" name="popular" class="form-check-input" id="popular">
                                                    <label class="form-check-label" for="popular">Popular</label>
                                                    <span class="input-error text-danger" data-input="popular"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Features</label>
                                                <div class="d-flex add-feature">
                                                    <select name="features[]" multiple="multiple" style="width:100%;">
                                                        @foreach (\App\Models\SubscriptionPlan::features() as $feature)
                                                            <option value="{{$feature}}">{{$feature}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="input-error text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" id="summernote"></textarea>
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
                            <a href="{{route('admin.subscription-plans.index')}}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success float-right">Store</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/subscription-plans.js') }}"></script>
@endpush
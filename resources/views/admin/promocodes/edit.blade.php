@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit promo code</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.promocodes.index')}}">Promo codes</a></li>
                            <li class="breadcrumb-item active">Edit promo code</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <form action="{{route('admin.promocodes.update', $promocode)}}" method="post" class="container-fluid general-ajax-submit">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Code</label>
                                            <input type="text" name="code" class="form-control" value="{{$promocode->code}}" placeholder="Code">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Discount type</label>
                                            <select class="select form-control" style="width:100%;">
                                                <option value="{{$promocode->type}}">{{$promocode->type}}</option>
                                            </select>
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Discount</label>
                                            <input type="number" value="{{$promocode->discount}}" class="form-control" placeholder="Discount" readonly>
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Date from - to</label>
                                            <div class="base-datepicker input-group date" id="date-from" data-target-input="nearest">
                                                <input type="text" value="{{$promocode->active_from->format('m/d/Y') . ' - ' . $promocode->active_to->format('m/d/Y')}}" class="form-control daterangepicker-input" data-target="#date-from" readonly>
                                                <div class="input-group-append" data-target="#date-from" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
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
                        <a href="{{route('admin.promocodes.index')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="float-left">
                            <h1 class="m-0 text-dark">Stocks</h1>
                        </div>
                        {{-- <div class="float-left pl-3">
                            <a href="{{route('admin.stocks.create')}}" class="btn btn-primary">+ Add Stock</a>
                        </div> --}}
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Stocks</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <select class="table-filter form-control" name="type">
                                            @foreach (\App\Models\StockType::all() as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-1 text-center pt-1">
                                        OR
                                    </div>
                                    <div class="col-lg-3">
                                        <form action="{{route('admin.stocks.types.store')}}" method="post" class="general-ajax-submit">
                                            @csrf
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-control">
                                                <span class="input-group-append">
                                                    <button type="submit" class="btn btn-success btn-flat">Create type</button>
                                                </span>
                                            </div>
                                            <span class="input-error text-danger"></span>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if (\App\Models\Stock::count())
                                <div class="card-body">
                                    <table id="stocks-table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Open</th>
                                            <th>High</th>
                                            <th>Low</th>
                                            <th>Close</th>
                                            <th>Adj Close</th>
                                            <th>Volume</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="card-header">
                                    @if (\App\Models\StockType::count())
                                        Please wait until stocks been updated.
                                    @else
                                        At leat one stock type must be created in order to see stocks.
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/admin/js/stocks.js')}}"></script>
@endpush
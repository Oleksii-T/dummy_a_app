@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="float-left">
                            <h1 class="m-0 text-dark">Subscriptions</h1>
                        </div>
                        {{-- <div class="float-left pl-3">
                            <a href="{{route('admin.subscriptions.create')}}"
                               class="btn btn-primary">+ Add subscription
                            </a>
                        </div> --}}
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Subscriptions</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="subscriptions-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="ids-column">ID</th>
                                        <th>User</th>
                                        <th>Plan</th>
                                        <th>Created at</th>
                                        <th>Expire at</th>
                                        <th class="actions-column-2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
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
    <script src="{{ asset('assets/admin/js/subscriptions.js') }}"></script>
@endpush
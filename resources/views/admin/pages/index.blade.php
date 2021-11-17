@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="float-left">
                            <h1 class="m-0 text-dark">Pages</h1>
                        </div>
                        <div class="float-left pl-3">
                            <a href="{{route('admin.pages.create')}}" class="btn btn-primary">+ Add Page</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pages</li>
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
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <select class="table-filter form-control" name="status">
                                            <option value="">Status filter</option>
                                            @foreach (\App\Models\Page::STATUSES as $status)
                                                <option value="{{$status}}">{{$status}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="pages-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="ids-column">ID</th>
                                        <th>Title</th>
                                        <th>URL</th>
                                        <th>Status</th>
                                        <th>Date</th>
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
    <script src="{{asset('assets/admin/js/pages.js')}}"></script>
@endpush

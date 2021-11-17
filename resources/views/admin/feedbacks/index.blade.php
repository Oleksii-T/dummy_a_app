@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="float-left">
                            <h1 class="m-0 text-dark">Feedbacks</h1>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Feedbacks</li>
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
                                        <select class="table-filter form-control" name="is_read">
                                            <option value="">Readed status filter</option>
                                            <option value="1">Readed</option>
                                            <option value="0">Not readed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="feedbacks-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="ids-column">ID</th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Content</th>
                                        <th>Date</th>
                                        <th style="width: 210px">Actions</th>
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
    <script src="{{asset('assets/admin/js/feedbacks.js')}}"></script>
@endpush

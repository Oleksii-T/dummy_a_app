@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="float-left">
                            <h1 class="m-0 text-dark">Users</h1>
                        </div>
                        <div class="float-left pl-3">
                            <a href="{{route('admin.users.create')}}" class="btn btn-primary">+ Create User</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                                    <div class="col-lg-4">
                                        <select class="table-filter form-control" name="status">
                                            <option value="">Avtivity status filter</option>
                                            <option value="1">Online</option>
                                            <option value="0">Offline</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="users-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="ids-column">#ID</th>
                                        <th>User name</th>
                                        <th>Ordes</th>
                                        <th>Status</th>
                                        <th class="actions-column-2">Actons</th>
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
    <script src="{{asset('assets/admin/js/users.js')}}"></script>
@endpush

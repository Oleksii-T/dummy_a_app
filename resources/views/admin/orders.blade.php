@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Orders</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">All Orders</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Orders</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Date</th>
                                        <th>User name</th>
                                        <th>Status</th>
                                        <th>Actons</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>12.12.21</td>
                                        <td>
                                            Jon Doe
                                        </td>
                                        <td><span class="badge bg-success">Сompleted</span></td>
                                        <td style="width: 100px;">
                                            <div class="table-actions d-flex align-items-center">
                                                <a href="{{route('admin.users.edit')}}" type="button" class="btn btn-primary btn-sm mr-1">Сonfirm</a>
                                                <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>12.12.21</td>
                                        <td>
                                            Jon Doe
                                        </td>
                                        <td><span class="badge bg-warning">Waiting approval</span></td>
                                        <td style="width: 100px;">
                                            <div class="table-actions d-flex align-items-center">
                                                <a href="{{route('admin.users.edit')}}" type="button" class="btn btn-primary btn-sm mr-1">Сonfirm</a>
                                                <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection

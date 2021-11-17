@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Tax</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.taxes.index')}}">Taxes</a></li>
                            <li class="breadcrumb-item active">Edit Tax</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <form action="{{route('admin.taxes.update', $tax)}}" method="post" class="container-fluid general-ajax-submit">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" name="title" class="form-control" value="{{$tax->title}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Percentage</label>
                                            <input type="text" class="form-control" value="{{$tax->percentage}}" readonly>
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="is_active" class="custom-control-input" id="customSwitch1" {{$tax->is_active ? 'checked' : ''}}>
                                                <label class="custom-control-label" for="customSwitch1">Active</label>
                                            </div>
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch2" {{$tax->is_inclusive ? 'checked' : ''}} disabled>
                                                <label class="custom-control-label" for="customSwitch2">Inclusive</label>
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
                        <a href="{{route('admin.taxes.index')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

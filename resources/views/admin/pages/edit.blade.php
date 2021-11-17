@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit page</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.pages.index')}}">Pages</a></li>
                            <li class="breadcrumb-item active">Edit page</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <form action="{{route('admin.pages.update', $page)}}" method="post" class="container-fluid general-ajax-submit">
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
                                            <input type="text" class="form-control" name="title" value="{{$page->title}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>URL</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">{{url('') . '/'}}</span>
                                                </div>
                                                <input type="text" class="form-control" name="url" value="{{$page->url}}" {{$page->status == 'static' ? 'disabled' : ''}}>
                                            </div>
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Seo title</label>
                                            <input type="text" class="form-control" name="seo_title" value="{{$page->seo_title}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Seo description</label>
                                            <input type="text" class="form-control" name="seo_description" value="{{$page->seo_description}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="select form-control" name="status" style="width:100%;">
                                                @if ($page->status == 'static')
                                                    <option value="static">static</option>
                                                @else
                                                    <option value="draft" {{$page->status=='draft' ? 'selected' : ''}}>draft</option>
                                                    <option value="published" {{$page->status=='published' ? 'selected' : ''}}>published</option>
                                                @endif
                                            </select>
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    @if ($page->status != 'static')
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Content</label>
                                                <textarea id="summernote" name="content">{{$page->content}}</textarea>
                                                <span class="input-error text-danger"></span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('admin.pages.index')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit blog</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.blogs.index')}}">Blogs</a></li>
                            <li class="breadcrumb-item active">Edit blog</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <form action="{{route('admin.blogs.update', $blog)}}" method="post" class="container-fluid general-ajax-submit">
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
                                            <input type="text" name="title" class="form-control" value="{{$blog->title}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Slug</label>
                                            <input type="text" name="slug" class="form-control" value="{{$blog->slug}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Seo Title</label>
                                            <input type="text" name="seo_title" class="form-control" value="{{$blog->seo_title}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Seo Description</label>
                                            <input type="text" name="seo_description" class="form-control" value="{{$blog->seo_description}}">
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Choose categories</label>
                                            <select class="select2" name="categories[]" multiple="multiple" data-placeholder="Choose categories" style="width: 100%;">
                                                @foreach (\App\Models\BlogCategory::all() as $category)
                                                    <option value="{{$category->id}}" {{$blog->categories()->pluck('id')->contains($category->id) ? 'selected' : ''}}>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Content</label>
                                            <textarea name="content" id="summernote">{!!$blog->content!!}</textarea>
                                            <span class="input-error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group general-file-input-with-preview">
                                            <label>Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="image" id="file-input" data-preview="image">
                                                    <label class="custom-file-label" for="file-input">{{$blog->image->original_name}}</label>
                                                </div>
                                            </div>
                                            <span class="input-error text-danger"></span>
                                            <div class="custom-file-preview">
                                                <img src="{{$blog->image->url}}" alt="" data-preview="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('admin.blogs.index')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
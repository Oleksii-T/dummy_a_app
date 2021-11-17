@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Site Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <form action="{{route('admin.settings.site.update')}}" method="post" class="container-fluid general-ajax-submit-with-files">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <div class="site-logo">
                                                        <img src="{{\App\Models\Setting::get('site_logo')->url??asset('assets/website/img/logo.svg')}}" alt="logo" data-preview="logo">
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="input-group general-file-input-with-preview">
                                                        <div class="custom-file">
                                                            <input type="file" name="site_logo" class="custom-file-input" id="exampleInputFile" data-preview="logo">
                                                            <label class="custom-file-label" for="exampleInputFile">{{App\Models\Setting::get('site_logo')->original_name??null}}</label>
                                                        </div>
                                                    </div>
                                                    <span class="input-error text-danger" data-input="site_logo"></span>
                                                </div>
                                            </div>
                                            <span class="input-error text-danger"></span>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Facebook</label>
                                                    <input type="text" class="form-control" name="facebook" value="{{\App\Models\Setting::get('facebook')}}">
                                                    <span class="input-error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Instagram</label>
                                                    <input type="text" class="form-control" name="instagram" value="{{\App\Models\Setting::get('instagram')}}">
                                                    <span class="input-error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Twitter</label>
                                                    <input type="text" class="form-control" name="twitter" value="{{\App\Models\Setting::get('twitter')}}">
                                                    <span class="input-error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Youtube</label>
                                                    <input type="text" class="form-control" name="youtube" value="{{\App\Models\Setting::get('youtube')}}">
                                                    <span class="input-error text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Facebook App ID</label>
                                                    <input type="text" class="form-control" name="facebook_app_id" value="{{\App\Models\Setting::get('facebook_app_id')}}">
                                                    <span class="input-error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Facebook App Secret</label>
                                                    <input type="text" class="form-control" name="facebook_app_secret" value="{{\App\Models\Setting::get('facebook_app_secret')}}">
                                                    <span class="input-error text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Google App ID</label>
                                                    <input type="text" class="form-control" name="google_app_id" value="{{\App\Models\Setting::get('google_app_id')}}">
                                                    <span class="input-error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Google App Secret</label>
                                                    <input type="text" class="form-control" name="google_app_secret" value="{{\App\Models\Setting::get('google_app_secret')}}">
                                                    <span class="input-error text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Twitter App ID</label>
                                                    <input type="text" class="form-control" name="twitter_app_id" value="{{\App\Models\Setting::get('twitter_app_id')}}">
                                                    <span class="input-error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Twitter App Secret</label>
                                                    <input type="text" class="form-control" name="twitter_app_secret" value="{{\App\Models\Setting::get('twitter_app_secret')}}">
                                                    <span class="input-error text-danger"></span>
                                                </div>
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
                        <a href="{{route('admin.index')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

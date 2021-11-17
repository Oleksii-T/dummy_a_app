@extends('website.layouts.app')

@section('header')
    @include('website.layouts.inc.header')
@endsection

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="sing-in">
                <div class="offer-image">
                    <img src="{{asset('assets/website/img/graf.svg')}}">
                </div>
                <div class="container sing-in__container">
                    <form action="{{route('website.login')}}" method="post" class="sing-in__form" id="login" data-home="{{route('website.profile')}}">
                        @csrf
                        <h3 class="sing-in__title">
                            Login to Account
                        </h3>
                        <div class="login-from">
                            @if (\App\Models\Setting::get('google_app_id') && \App\Models\Setting::get('google_app_secret'))
                                <a href="{{route('website.social.login', 'google')}}" class="login-from__item">
                                    <img src="{{asset('assets/website/img/flat-color-icons_google.svg')}}" alt="">
                                    <span>Login with Google</span>
                                </a>
                            @endif
                            @if (\App\Models\Setting::get('facebook_app_id') && \App\Models\Setting::get('facebook_app_secret'))
                                <a href="{{route('website.social.login', 'facebook')}}" class="login-from__item">
                                    <img src="{{asset('assets/website/img/facebook.svg')}}" alt="">
                                    <span>Login with Facebook</span>
                                </a>
                            @endif
                            @if (\App\Models\Setting::get('twitter_app_id') && \App\Models\Setting::get('twitter_app_secret'))
                                <a href="{{route('website.social.login', 'twitter')}}" class="login-from__item">
                                    <img src="{{asset('assets/website/img/akar-icons_twitter-fill.svg')}}" alt="">
                                    <span>Login with Twitter</span>
                                </a>
                            @endif
                        </div>
                        <div class="divider">Or</div>
                        <div class="input-group">
                            <label class="input-group__title">Email address</label>
                            <input type="text" class="input" name="email" value="{{old('email')}}">
                            @error('email')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="input-group">
                            <label class="input-group__title">Password</label>
                            <div class="input-wrapper">
                                <input type="password" class="input" name="password">
                                <button type="button" class="input-button"><img src="{{asset('assets/website/img/eye-cross_1.svg')}}" alt=""></button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-row">
                            <label class="module__check">
                                <input type="checkbox" name="privacy_policy" checked>
                                <span class="check"></span>
                                <span class="text-module">Remember Me</span>
                            </label>
                            <a href="{{route('password.request')}}" class="blue-link">
                                Forgot Password?
                            </a>
                        </div>
                        <button type="submit" class="btn btn-sm btn-blue">
                            Log In
                        </button>
                        <p class="login-form__text">Don’t have an account yet? <a href="{{route('website.sign-up')}}" class="blue-link">Sign up</a></p>
                    </form>
                </div>
            </section>
        </main>
        @include('website.layouts.inc.footer-empty')
    </div>
@endsection

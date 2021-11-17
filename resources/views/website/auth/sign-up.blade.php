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
                    <form action="{{route('register')}}" class="sing-in__form" method="POST">
                        @csrf
                        <h3 class="sing-in__title">
                            Create your free account
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
                            <input type="text" class="input" name="email" placeholder="alma.lawson@example.com" value="{{old('email')}}">
                            @error('email')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="input-group">
                            <label class="input-group__title">Password</label>
                            <div class="input-wrapper">
                                <input type="password" class="input" name="password" placeholder="•••••••••••••••••••••">
                                <button type="button" class="input-button"><img src="{{asset('assets/website/img/eye-cross_1.svg')}}" alt=""></button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="input-group">
                            <label class="input-group__title">Confirm Password</label>
                            <div class="input-wrapper">
                                <input type="password" class="input" name="password_confirmation" placeholder="•••••••••••••••••••••">
                                <button type="button" class="input-button"><img src="{{asset('assets/website/img/eye-cross_1.svg')}}" alt=""></button>
                            </div>
                            @error('password_confirmation')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        </div>
                        <div style="margin-bottom: 15px">
                            <div class="form-row">
                                <label class="module__check">
                                    <input type="checkbox" name="privacy_policy" checked>
                                    <span class="check"></span>
                                    <span class="text-module">I agree to the Terms & Conditions</span>
                                </label>
                            </div>
                            @error('privacy_policy')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-sm btn-blue">
                            Sign Up
                        </button>
                        <p class="login-form__text">Already have an account? <a href="{{route('website.login')}}" class="blue-link">Login</a></p>
                    </form>
                </div>
            </section>
        </main>
        @include('website.layouts.inc.footer-empty')
    </div>
@endsection

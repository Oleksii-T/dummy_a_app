@extends('website.layouts.app')

@section('header')
    @include('website.layouts.inc.header')
@endsection

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="contact-us first-section-padding">
                <div class="container contact-us__container">
                    <div class="contact-us__body">
                        <h2 class="section-title">Contact Us</h2>
                        <div class="contact-data">
                            <div class="contact-data__item">
                                <label>Address</label>
                                <a href="#">ADDRESS</a>
                            </div>
                            <div class="contact-data__item">
                                <label>Email</label>
                                <a href="mailto:example@example.com">EMAIL</a>
                            </div>
                        </div>
                        <form action="{{route('website.contact-us.store')}}" method="post" class="contact-form">
                            @csrf
                            <div class="contact-form__row">
                                <div class="contact-form__col">
                                    <div class="input-group">
                                        <label class="input-group__title">Name</label>
                                        <input type="text" class="input" name="name" value="{{isset($currentUser) && $currentUser ? ($currentUser->first_name . ' ' . $currentUser->last_name) : ''}}">
                                        <span class="input-error invalid-feedback"></span>
                                    </div>
                                    <div class="input-group">
                                        <label class="input-group__title">Email address</label>
                                        <input type="text" class="input" name="email" value="{{isset($currentUser) && $currentUser ? $currentUser->email : ''}}">
                                        <span class="input-error invalid-feedback"></span>
                                    </div>
                                </div>
                                <div class="contact-form__col">
                                    <div class="input-group h-full">
                                        <label class="input-group__title">Message</label>
                                        <textarea class="input" name="content">I would like to launch new simulation...</textarea>
                                        <span class="input-error invalid-feedback"></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-blue btn-sm">Send a Message</button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
        @include('website.layouts.inc.footer')
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/website/js/feedbacks.js')}}"></script>
@endpush

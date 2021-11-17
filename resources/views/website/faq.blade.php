@extends('website.layouts.app')

@section('header')
    @include('website.layouts.inc.header')
@endsection

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="fqa first-section-padding">
                <div class="container fqa__container">
                    <div class="fqa__body">
                        <h2 class="section-title">We are here to help</h2>
                        <p class="section-subtitle">Browse through our most frequently asked questions</p>
                        <div class="acordeon">
                            <ul class="accordion-list">
                                @isset($faqs)
                                    @foreach($faqs as $faq)
                                        <li>
                                            <h4>
                                                {{"$faq->id. $faq->question"}}
                                                <img src="{{asset('assets/website/img/acordeon-arrow.svg')}}" alt="">
                                            </h4>
                                            <div class="answer">
                                                <p>{!!$faq->answer!!}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                @endisset
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        @include('website.layouts.inc.footer')
    </div>
@endsection

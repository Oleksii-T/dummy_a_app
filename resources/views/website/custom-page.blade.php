@extends('website.layouts.app')

@section('header')
    @include('website.layouts.inc.header')
@endsection

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="blog-news first-section-padding">
                <div class="container blog-news__container">
                    <div class="blog-news__body">
                        <h2 class="section-title">{{$page->title}}</h2>
                        <div>
                            {!!$page->content!!}
                        </div>
                    </div>
                </div>
            </section>
        </main>
        @include('website.layouts.inc.footer')
    </div>
@endsection

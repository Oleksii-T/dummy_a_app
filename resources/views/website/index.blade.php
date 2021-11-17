@extends('website.layouts.app')
@section('header')
    @include('website.layouts.inc.header')
@endsection

@section('content')
    <div class="wrapper_main">
        <main class="content">
            <section class="blog pd-100">
                {{-- CONTENT --}}
            </section>
            <section class="blog pd-100">
                {{-- CONTENT --}}
            </section>
            <section class="blog pd-100">
                {{-- CONTENT --}}
            </section>
            <section class="blog pd-100">
                {{-- CONTENT --}}
            </section>
            <section class="blog pd-100">
                <div class="container">
                    <div class="head-flex">
                        <div class="info">
                            <h2>Blog</h2>
                            <span>Here are some screenshots of our product and features</span>
                        </div>
                        <div class="action">
                            <a href="{{route('website.blogs.index')}}" class="btn btn-sm btn-blue">Show More</a>
                        </div>
                    </div>
                    <div class="blog-posts">
                        <div class="custom-row blog-news__row">
                            @foreach (\App\Models\Blog::latest()->limit(3)->get() as $blog)
                                <article class="article-item preveiw">
                                    <a href="#">
                                        <div class="article-item__img">
                                            <img src="{{$blog->image->url}}" alt="">
                                        </div>
                                        <h3 class="article-item__title">{{$blog->title}}</h3>
                                        <span class="article-item__date">{{$blog->created_at->format('M d, Y')}}</span>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('website.layouts.inc.footer')
    </div>
@endsection

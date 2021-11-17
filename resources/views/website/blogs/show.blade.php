@extends('website.layouts.app')

@section('header')
    @include('website.layouts.inc.header')
@endsection

@push('meta')
    @if ($blog->seo_title)
        <meta name="title" content="{{$blog->seo_title}}">
        <meta name="og:title" content="{{$blog->seo_title}}">
    @endif
    @if ($blog->seo_description)
        <meta name="description" content="{{$blog->seo_description}}">
        <meta name="og:description" content="{{$blog->seo_description}}">
    @endif
@endpush

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="post-page">
                <div class="container post-page__container">
                    <div class="post-page__body">
                        <span class="post-page__data">
                            {{$blog->created_at->format('M d, Y')}}
                        </span>
                        <h2 class="section-title">
                            {{$blog->title}}
                        </h2>
                        <div class="post-page__img">
                            <img src="{{asset($blog->image->url)}}" alt="">
                        </div>
                        <div class="text">
                            {!! $blog->content !!}
                        </div>
                    </div>
                </div>
            </section>
            <div class="share">
                <div class="container share__container">
                    <div class="share__body">
                        <h3 class="share__title">
                            Share
                        </h3>
                        <div class="share-links">
                            <a href="{{'https://www.facebook.com/sharer/sharer.php?u=' . Request::url()}}" target="_blank" class="share-links__item">
                                <img src="{{asset('assets/website/img/share-1.svg')}}" alt="">
                            </a>
                            <a href="{{'https://twitter.com/intent/tweet?text=' . $blog->title . '&url=' . Request::url()}}" target="_blank" class="share-links__item">
                                <img src="{{asset('assets/website/img/share-2.svg')}}" alt="">
                            </a>
                            {{-- <a href="{{'https://www.instagram.com/?url=' . Request::url()}}" target="_blank" class="share-links__item">
                                <img src="{{asset('assets/website/img/share-5.jpg')}}" alt="">
                            </a> --}}
                            <a href="#" class="share-links__item mail-share" data-id="{{$blog->id}}">
                                <img src="{{asset('assets/website/img/share-4.svg')}}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @if ($latest->isNotEmpty())
                <section class="blog inner pd-100">
                    <div class="container">
                        <div class="head-flex">
                            <div class="info">
                                <h2>You can like these</h2>
                            </div>
                            <a href="{{route('website.blogs.index')}}" class="btn btn-sm btn-blue">Show More</a>
                        </div>
                        <div class="blog-posts">
                            <div class="custom-row">
                                @isset($latest)
                                    @foreach($latest as $blog)
                                        <article class="article-item preveiw">
                                            <a href="{{route('website.blogs.show', $blog->slug)}}">
                                                <div class="article-item__img">
                                                    <img src="{{asset($blog->image->url)}}" alt="">
                                                </div>
                                                <h3 class="article-item__title">{{$blog->title}}</h3>
                                                <span class="article-item__date">{{$blog->created_at->format('M d, Y')}}</span>
                                            </a>
                                        </article>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </main>
        @include('website.layouts.inc.footer')
    </div>
@endsection

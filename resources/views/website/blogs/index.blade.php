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
                        <h2 class="section-title">Blog</h2>
                        <div class="custom-row blog-news__row">
                            @isset($blogs)
                                @foreach($blogs as $blog)
                                    <article class="article-item preveiw">
                                        <a href="{{route('website.blogs.show', $blog->slug)}}">
                                            <div class="article-item__img">
                                                <img src="{{$blog->image->url}}" alt="">
                                            </div>
                                            <h3 class="article-item__title">{{$blog->title}}</h3>
                                            <span class="article-item__date">{{$blog->created_at->format('M d, Y')}}</span>
                                        </a>
                                    </article>
                                @endforeach
                            @endisset
                        </div>
                        <div class="pagination">
                            {{$blogs->links('website.layouts.inc.pagination')}}
                        </div>
                    </div>
                </div>
            </section>
        </main>
        @include('website.layouts.inc.footer')
    </div>
@endsection

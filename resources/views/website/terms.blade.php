@extends('website.layouts.app')

@section('header')
    @include('website.layouts.inc.header')
@endsection

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="post-page">
                {{-- CONTENT --}}
            </section>
        </main>
        @include('website.layouts.inc.footer')
    </div>
@endsection

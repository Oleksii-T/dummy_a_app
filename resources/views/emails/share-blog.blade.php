@component('mail::message')
# {{$subject}}

{{$blog->seo_description}}

@component('mail::button', ['url' => route('website.blogs.show', $blog)])
    See blog
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
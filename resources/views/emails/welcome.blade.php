@component('mail::message')
    <h3>Welcome!</h3>
    You have successfully registered.

    Thanks,
    {{ config('app.name') }}
@endcomponent
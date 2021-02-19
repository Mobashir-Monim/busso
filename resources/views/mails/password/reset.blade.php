@component('mail::message')

Hi {{ $name }}!

Your account password has been resetted. If you did not reset the password please secure your account by resetting the password.


@component('mail::button', ['url' => route('password.reset')])
Reset {{ env('APP_NAME') }} Password
@endcomponent


@endcomponent
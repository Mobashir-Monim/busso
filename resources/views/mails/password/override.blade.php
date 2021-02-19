@component('mail::message')

Hi {{ $name }}!

Your {{ env('APP_NAME') }} account password was overriden by a Super Admin.

Please use the following credentials to login:
@component('mail::panel')
Email: <b>{{ $email }}</b><br>
Password: <b>{{ $pass }}</b>
@endcomponent

After the first login please change your password.

@component('mail::button', ['url' => route('login')])
Login to {{ env('APP_NAME') }}
@endcomponent


@endcomponent
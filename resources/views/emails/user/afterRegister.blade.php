@component('mail::message')
    # Welcome

    Hi {{ $user->name }}

    Welcome to Laracamp, ur account success created. Now u can choose the best camp!

    @component('mail::button', ['url' => route('login')])
        Login Here
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent

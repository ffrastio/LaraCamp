@component('mail::message')
# Your Transaction Has been confirmed

Hi {{ $checkout->User->name }}
<br>
Now u can enjoy with the benefits of {{ $checkout->Camp->title }} camp.

@component('mail::button', ['url' => route('user.dashboard')])
My Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

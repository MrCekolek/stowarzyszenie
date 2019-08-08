@component('mail::message')
# Account authentication

Click on the button below to activate account.

@component('mail::button', ['url' => 'http://localhost:8000/api/activateAccount?token=' . $token])
    Activate Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

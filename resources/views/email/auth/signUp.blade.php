@component('mail::message')
# Account authentication

Click on the button below to activate account.

@component('mail::button', ['url' =>  config('app.back_url') . '/api/activateAccount?token=' . $token])
    Activate Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

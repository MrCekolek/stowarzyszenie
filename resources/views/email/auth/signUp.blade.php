@component('mail::message')
# {{ __('custom.blade.signUp.signup_request', [], $lang) }}

{{ __('custom.blade.signUp.before_information', [], $lang) }}

@component('mail::button', ['url' =>  config('app.url') . '/api/account/activate?token=' . $token])
    {{ __('custom.blade.signUp.button_name', [], $lang) }}
@endcomponent

{{ __('custom.blade.signUp.after_information', [], $lang) }} <br>
{{ config('app.name') }}
@endcomponent

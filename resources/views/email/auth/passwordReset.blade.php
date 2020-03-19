@component('mail::message')
# {{ __('custom.blade.passwordReset.change_request', [], $lang) }}

{{ __('custom.blade.passwordReset.before_information', [], $lang) }}

@component('mail::button', ['url' => config('app.front_url') . '/auth/onreset?login_email=' . $email . '&token=' . $token])
    {{ __('custom.blade.passwordReset.button_name', [], $lang) }}
@endcomponent

{{ __('custom.blade.passwordReset.after_information', [], $lang) }} <br>
{{ config('app.name') }}
@endcomponent

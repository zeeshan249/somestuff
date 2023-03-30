@component('mail::message')

<h1>{{ $details['loginId'] }}</h1>
<p>{{ $details['password'] }}</p>
@component('mail::button', ['url' => config('app.url')])
Login
@endcomponent

Thanks,<br>
{{ __('label.label_company_name') }}
@endcomponent

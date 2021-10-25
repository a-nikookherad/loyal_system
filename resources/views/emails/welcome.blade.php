@component('mail::message')
# welcome to loyal market

**loyal market is market place**

@component('mail::button', ['url' => 'http://localhost'])
go to your dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

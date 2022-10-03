@component('mail::message')
## Welcome YUMMOOHEE,

Your account has been successfully created. Please enter the code below to verify your email. 

# {{ $user->pin }}

Thanks, <br>
{{ config('app.name') }}
@endcomponent
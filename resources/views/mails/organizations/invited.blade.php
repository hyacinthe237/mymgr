@component('mail::message')
# Invitation

Hi {{ $invitation->firstname }},

You have been invited by {{ $invitation->sentBy->name }}
to join {{ $invitation->organization->name }} on IzyPM.

<br> Please, click on the link below to join.

@component('mail::button', ['url' => $url])
Join us
@endcomponent

Regards,<br>
{{ config('app.name') }}
<br>Project management made izy
@endcomponent

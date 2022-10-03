@component('mail::message')
# Booking Completed

Hi {{ $booking->client->firstname }},
<br>Booking No {{ $booking->number }} has been marked as completed.
<br>Thanks for using Yummooh

<br>
## Booking details
Booking No: {{ $booking->number }}
<br>Date & time: {{ date('d F Y H:i', strtotime($booking->start_time)) }}

Thanks, <br>
{{ config('app.name') }}
@endcomponent
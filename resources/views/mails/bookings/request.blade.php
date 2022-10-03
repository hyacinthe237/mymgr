@component('mail::message')
# Booking Request

Hi {{ $booking->chef->firstname }},
<br>You received a booking request from {{ $booking->client->firstname }} {{ $booking->client->lastname }}.
<br>Please respond to the request from the app.


## Booking details
Booking No: {{ $booking->number }}
<br>Date & time: {{ date('d F Y H:i', strtotime($booking->start_time)) }}

Thanks, <br>
{{ config('app.name') }}
@endcomponent
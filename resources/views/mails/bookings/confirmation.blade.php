@component('mail::message')
# Booking Confirmation

Hi {{ $booking->client->firstname }},
<br>Here is a confirmation of your booking request to chef {{ $booking->client->firstname }} {{ $booking->client->lastname }}.
<br>Please note that {{ $booking->client->firstname }} still needs to approve your booking request.


## Booking details
Booking No: {{ $booking->number }}
<br>Date & time: {{ date('d F Y H:i', strtotime($booking->start_time)) }}

Thanks, <br>
{{ config('app.name') }}
@endcomponent
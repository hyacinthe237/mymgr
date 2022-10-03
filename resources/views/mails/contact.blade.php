@component('mail::message')
## New Contact Form Submission,

Hi Boss, 
We received a new submission from the contact form with the following details: 

# Name
{{ $form['name'] }}

# Email 
{{ $form['email'] }}

# Content
{{ $form['content'] }}


<br>
{{ config('app.name') }}
@endcomponent
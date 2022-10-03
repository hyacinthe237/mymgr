@extends('frontend.layout.master')


@section('head')
    <title>About Us | Yummooh</title>
@endsection



@section('body')
<div class="_large-header">
    <div class="header-logo">
        <a href="/">
            <img src="/assets/images/yummooh_logo_long.png" alt="">
        </a>

        <p class="mt-20"></p>
    </div>
</div>


<div class="landing-image" style="background-image: url('/assets/images/couple-dining.jpeg')">
    <div class="landing-image-container"></div>
</div>


<div class="text-content bg-primary">
    <div class="container">
        <h2>About Us</h2>

        <p class="mt-10">
            Yummooh is a platform that allows clients to book private chefs to cook at their residence.
        </p>
    </div>
</div>


<div class="landing-image" style="background-image: url('/assets/images/vision.jpeg')">
    <div class="landing-image-container"></div>
</div>

<div class="text-content bg-primary">
    <div class="container">
        <h2>Vision</h2>

        <p class="mt-10">
            We want to create a world where everyday feels like a holiday
        </p>
    </div>
</div>

<div class="landing-image" style="background-image: url('/assets/images/mission.jpeg')">
    <div class="landing-image-container"></div>
</div>


<div class="text-content bg-primary">
    <div class="container">
        <h2>Mission</h2>

        <p class="mt-10">
            To give people the opportunity to live the lifestyle they deserve
        </p>
    </div>
</div>


<div class="landing-image" style="background-image: url('/assets/images/value.jpeg')">
    <div class="landing-image-container"></div>
</div>


<div class="text-content bg-primary">
    <div class="container">
        <h2>Core Values</h2>

        <p class="mt-10">
            <ul class="list-unstyled">
                <li>- Customer experience before anything</li>
                <li>- People dream, we give them the real experience</li>
                <li>- Lead, inspire, create and challenge the current experience</li>
                <li>- Honest, respectful and responsive communication</li>
                <li>- Create an environment, culture and business that people believe in</li>
            </ul>
        </p>
    </div>
</div>


@include('frontend.includes.footer')
@endsection




@extends('frontend.layout.master')


@section('head')
    <title>Welcome to Yummooh</title>
    <meta name="description" content="Yummooh is a platform that allows clients to book private chefs to cook at their residence"/>

    <meta property="og:title" content="Welcome to Yummooh" />
    <meta property="og:description" content="Yummooh is a platform that allows clients to book private chefs to cook at their residence"/>
    <meta property="og:url" content="https://yummooh.com" />
    <meta property="og:image" content="https://yummooh.sgp1.digitaloceanspaces.com/web/couple-dining.jpeg" />

    <meta name="twitter:title" content="Welcome to Yummooh"/>
    <meta name="twitter:description" content="Yummooh is a platform that allows clients to book private chefs to cook at their residence"/>
    <meta name="twitter:image" content="https://yummooh.sgp1.digitaloceanspaces.com/web/couple-dining.jpeg">
    <meta name="twitter:card" content="summary_large_image">
@endsection


@section('content')
<div class="_landing-page">
    <div class="landing-page-top">
        <div class="landing-page-logo">
            <img src="/assets/images/yummooh_logo_long.png" alt="">

            <div class="landing-motto">
                Private chefs for you
            </div>
        </div>

        <div class="landing-menu">
            <div class="container">
                <div class="text-center">
                    <a href="/become-chef" class="btn btn-white mr-20">
                        Je veux créer un projet
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('frontend.includes.footer')
@endsection

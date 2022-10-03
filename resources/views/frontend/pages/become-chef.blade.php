@extends('frontend.layout.master')


@section('head')
    <title>Become a Chef | Yummooh</title>
@endsection



@section('body')
<div class="_large-header">
    <div class="header-logo">
        <a href="/">
            <img src="/assets/images/yummooh_logo_long.png" alt="">
        </a>

        <p class="mt-20">
            People dream, our chefs give them the real experience
        </p>
    </div>
</div>


<div class="landing-image" style="background-image: url('/assets/images/become-chef.jpeg')">
    <div class="landing-image-container"></div>
</div>

<div class="text-content bg-primary">
    <div class="row">
        <div class="col-sm-3"></div>

        <div class="col-sm-6">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @else

            <h4>Interested in becoming a Yummooh chef? Leave your email</h4>

            <div class="mailing-form">
                <form method="post" action="/newsletter" class="_form mt-20">
                    <input type="hidden" name="other" value="chef">

                    {{ csrf_field() }}

                    <div class="form-group">
                        <input type="text"
                            class="form-control form-control-lg round text-center"
                            placeholder="Name"
                            name="name"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <input type="email"
                            class="form-control form-control-lg round text-center"
                            placeholder="Enter email"
                            name="email"
                            required
                        >
                    </div>

                    <div class="mt-20 text-right">
                        <button 
                            class="btn btn-dark btn-round w-150"
                        >Submit</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="text-content">
    <div class="container">
        <h2>Your Kitchen</h2>

        <p class="mt-10">
            Your kitchen on Yummooh platform should be consider as a physical shop or an asset that you own. 
        Why? because we have limited chefs on the platform, that means you can build your Kitchen 
        brand, which you can sell later if you wish. 
        </p>
    </div>
</div>

<div class="landing-image" style="background-image: url('/assets/images/kitchen.jpeg')">
    <div class="landing-image-container"></div>
</div>


@include('frontend.includes.footer')
@endsection




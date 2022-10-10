@extends('frontend.layout.master')


@section('head')
    <title>Contact Us | Yummooh</title>
@endsection



@section('content')
<div class="_large-header">
    <div class="header-logo">
        <a href="/">
            <img src="/assets/images/yummooh_logo_long.png" alt="">
        </a>

        <p class="mt-20"></p>
    </div>
</div>


<div class="landing-image" style="background-image: url('/assets/images/02.jpeg')">
    <div class="landing-image-container"></div>
</div>


<div class="text-content bg-primary">
    <div class="container">
        <h2>Contact Us</h2>

        <p class="mt-10">
            Yummooh is a platform that allows clients to book private chefs to cook at their residence.
        </p>

        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @else

                <div class="mailing-form">
                    <form method="post" action="/contact" class="_form mt-20">
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


                        <div class="form-group">
                            <textarea
                                name="content" rows="4"
                                class="form-control"
                                placeholder="Enter message here"
                                required
                            ></textarea>
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
</div>


@include('frontend.includes.footer')
@endsection

@extends('frontend.layout.auth')



@section('content')
    <section class="login-page">

            <div class="login-container">
                <div class="inner">
                    <div class="logo"></div>
                    <div class="logo-name">IzyPM</div>


                    <div class="links">
                        <a href="{{ route('organizations.join', ['code' => session('join_organization')->code]) }}" class="btn btn-primary" role="button">@lang('Join organization')</a>
                    </div>
                </div>
            </div>
        </section>
@endsection
